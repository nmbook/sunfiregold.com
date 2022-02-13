<?php

// 2020-09-20: PDO DATA LAYER API
// Nate Book / Ribose

if (isset($templ_page_valid) && $templ_page_valid)
{
    $script_embed = true;
}
else
{
    $templ_page_valid = true;
    $script_embed = false;
}

$_DB = [
	'host' => '',
	'dbname' => '',
	'charset' => 'utf8mb4',
	'user' => '',
	'pass' => ''
];
$_OPTS = [
	PDO::ATTR_CASE				 => PDO::CASE_LOWER,
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

include_once('db_creds.php');
include_once('stml.php');
include_once('k9data.php');

if ($script_embed === false)
{
    // do bare action (JavaScript AJAX API)
    $act = isset($_GET['act']) ? $_GET['act'] : '';
    $q = isset($_GET['q']) ? $_GET['q'] : '';
    $f = isset($_GET['f']) ? $_GET['f'] : '';
    $DBCONN = db_connect($_DB, $_OPTS);

    $acts = [
        '' => null,
        'print_dog' => 'printdog',
        'print_titles' => 'printtitles',
        'print_pedigree_link' => 'printped',
        'get_dog_by_id' => 'getdogbyid',
        'get_pedigree_by_id' => 'getpedbyid',
        'get_stml_template' => 'getstml',
        'get_litter_by_id' => 'getlitterbyid',
        'find_k9data_page' => 'findk9datapage',
        'find_pedigree_file' => 'findpedfile',
        'search_dog' => 'searchdog',
        'pages_find' => 'findpage',
        'pages_list' => 'listpages',
        'dogs_list' => 'listdogs',
        'litters_list' => 'listlitters',
        'pedigrees_list' => 'listpeds',
        'links_list' => 'listlinks',
    ];
    $act_masked = array_search($act, $acts);
    header('Content-Type: application/json');
    if (!empty($act_masked) && $act_masked !== false)
    {
        $act_masked = "api_$act_masked";
        set_error_handler('handle_api_error');
        echo json_encode($act_masked($DBCONN, $q, $f));
        restore_error_handler();
    }
    else
    {
        echo json_encode(json_result(false, 'Unknown action.'));
    }
}
else
{
    // prepare database (action call from require-er)
    $DBCONN = db_connect($_DB, $_OPTS);
}

function db_connect($_DB, $_OPTS)
{
    $user = $_DB['user'];
    unset($_DB['user']);
    unset($_DB['uname']);
    $pass = $_DB['pass'];
    unset($_DB['pass']);
    unset($_DB['upass']);
    $dsn = 'mysql:' . http_build_query($_DB, '', ';');
    try
    {
        $pdo = new PDO($dsn, $user, $pass, $_OPTS);
        return $pdo;
    }
    catch (\PDOException $e)
    {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

// return a MySQL date
// Style 0: DATETIME
// Style 1: DATE
// Style 2: TIME
function db_date($date, $style = 0)
{
    switch ($style)
    {
    default:
    case 0:
        return date('Y-m-d H:i:s', $date);
    case 1:
        return date('Y-m-d', $date);
    case 2:
        return date('H:i:s', $date);
    }
}


// API.PHP
function handle_api_error($errno, $errstr, $errfile, $errline = 0, $errcontext = [])
{
    if (!(error_reporting() & $errno))
    {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return false;
    }
    
    switch ($errno) {
    case E_ERROR:
        echo json_encode(json_result(false, "E_ERROR: $errstr"));
        exit(1);
    case E_WARNING:
        echo json_encode(json_result(false, "E_WARNING: $errstr"));
        exit(1);
    case E_NOTICE:
        echo json_encode(json_result(false, "E_NOTICE: $errstr"));
        exit(1);
    case E_STRICT:
        echo json_encode(json_result(false, "E_STRICT: $errstr"));
        exit(1);
    default:
        echo json_encode(json_result(false, "E($errno): $errstr"));
        exit(1);
    }

    /* Don't execute PHP internal error handler */
    return true;
}

function json_result($result, $text = '', $html = '', $extra = [])
{
    $res = ['result' => $result, 'text' => $text, 'html' => $html];
    return array_merge($res, $extra);
}

function session_action_insert($pdo, $table_name, $params, $save_action_log = false, $save_action_log_desc = '')
{
    $columns = '';
    $value_params = '';
    foreach ($params as $key => $value)
    {
        $columns .= "`$key`, ";
        $value_params .= ":$key, ";
    }
    if (strlen($columns) >= 2) { $columns = substr($columns, 0, -2); }
    if (strlen($value_params) >= 2) { $value_params = substr($value_params, 0, -2); }

    $sql = "INSERT INTO `$table_name` ( $columns ) VALUES ( $value_params )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $stmt = null;

    if ($save_action_log)
    {
        session_action_insert($pdo, 'actions', [
                'user_id' => $_SESSION['user_id'],
                'page_id' => get_page_id(),
                'date' => db_date(time()),
                'edit_type' => 'ADD',
                'data_desc' => $save_action_log_desc ], false);
    }

    return json_result(true, '', '', ['id' => $pdo->lastInsertId()]);
}

function session_action_update($pdo, $table_name, $matches, $params, $save_action_log = false, $save_action_log_desc = '')
{
    if (count($params) == 0)
    {
        throw new Exception('Must have something to update.');
    }
    $kvp_params = '';
    foreach ($params as $key => $value)
    {
        $kvp_params .= "`$key` = :$key, ";
    }
    if (strlen($kvp_params) >= 2) { $kvp_params = substr($kvp_params, 0, -2); }

    if (count($matches) > 0)
    {
        $kvp_matches = '';
        foreach ($matches as $key => $value)
        {
            $kvp_matches .= "`$key` = :$key AND ";
        }
        if (strlen($kvp_matches) >= 5) { $kvp_matches = substr($kvp_matches, 0, -5); }
    }
    else
    {
        $kvp_matches = '1';
    }
    $sql = "UPDATE `$table_name` SET $kvp_params WHERE $kvp_matches";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge($params, $matches));
    $stmt = null;

    if ($save_action_log)
    {
        session_action_insert($pdo, 'actions', [
                'user_id' => $_SESSION['user_id'],
                'page_id' => get_page_id(),
                'date' => db_date(time()),
                'edit_type' => 'EDIT',
                'data_desc' => $save_action_log_desc ], false);
    }

    return json_result(true);
}

function session_action_delete($pdo, $table_name, $matches, $save_action_log = false, $save_action_log_desc = '')
{
    if (count($matches) > 0)
    {
        $kvp_matches = '';
        foreach ($matches as $key => $value)
        {
            $kvp_matches .= "`$key` = :$key AND ";
        }
        if (strlen($kvp_matches) >= 5) { $kvp_matches = substr($kvp_matches, 0, -5); }
    }
    else
    {
        $kvp_matches = '1';
    }
    $sql = "DELETE FROM `$table_name` WHERE $kvp_matches";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge($params, $matches));
    $stmt = null;

    if ($save_action_log)
    {
        session_action_insert($pdo, 'actions', [
                'user_id' => $_SESSION['user_id'],
                'page_id' => get_page_id(),
                'date' => db_date(time()),
                'edit_type' => 'REMOVE',
                'data_desc' => $save_action_log_desc ], false);
    }

    return json_result(true);
}

// prints a dog from the dogs database in one of a few styles.
// Style 0: one line, for litters page
// Style 1: two lines, for our dogs page
// Style 2: no links with birth & death, for stories
// Style 3: nickname only
// Style 4: one line, text only
function api_print_dog($pdo, $id, $filter = '', $style = 0, $return_to = 'ourdogs')
{
    global $is_signed_in;

    $o = '';
    $t = '';
  
    $sql =
    '
     SELECT
     DATEDIFF(
              IF(`date_death_mask` = 0,
                 DATE(NOW()),
                 IF(`date_death_mask` = 1,
                    `date_death`,
                    IF(`date_death_mask` = 2,
                       DATE_ADD(MAKEDATE(YEAR(`date_death`), 1),
                                INTERVAL MONTH(`date_death`) MONTH),
                       IF(`date_death_mask` = 3,
                          MAKEDATE(YEAR(`date_death`), 1),
                          `date_birth`)))),
              `date_birth`) AS `age_days`,
     `id`,
     `name_short`, `name_full`,
     `titles_pre`, `titles_post`,
     `gender`,
     `k9data_id`, `pedigree_id`,
     `own_state`, `own_by`,
     `date_birth`, `date_death`,
     `date_death_mask`
    FROM `dogs`
    WHERE `id` = :id
    LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(false, 'Not found.');
    }
    
    $id = $row['id'];

    //$death_known =
    //    $row['date_death_mask'] == 1 ||
    //    $row['date_death_mask'] == 2 ||
    //    $row['date_death_mask'] == 3;

    if ($style == 3)
    {
        return json_result(true,
            $row['name_short'],
            htmlspecialchars($row['name_short']),
            ['id' => $id]);
    }

    if ($style == 1)
    {
        $o .= '<dt>';
    }

    //$row['age_days'] /= 365.25;
    //echo '('.($row[age_days]/365.25).')';

    if ($style == 1)
    {
        $age_years = $row['age_days'] / 365.25;
        $age_years += 0.05;
        if ($age_years >= 15)
        {
            $o .= '<span class="honor_age" title="This dog has lived for '.floor($age_years).' years">&bull;&bull;</span>';
        }
        else if ($age_years >= 14)
        {
            $o .= '<span class="honor_age" title="This dog has lived for 14 years">&bull;</span>';
        }
    }

    $pre_titles = api_print_titles($pdo, $row['titles_pre'], 'PRE', $style != 4);
    $o .= $pre_titles['html'];
    $t .= $pre_titles['text'];
    
    $o .= htmlspecialchars($row['name_full']);
    $t .= $row['name_full'];
    
    $post_titles = api_print_titles($pdo, $row['titles_post'], 'POST', $style != 4);
    $o .= $post_titles['html'];
    $t .= $post_titles['text'];

    if (strlen($row['name_short']) > 0)
    {
        if ($style == 4)
        {
            $o .= ' &quot;';
        }
        else
        {
            $o .= ' <q class="';

            if ($row['gender'] == 'MALE')
            {
                $o .= 'm';
            }
            else
            {
                $o .= 'f';
            }

            $o .= '">';
        }
        $t .= ' "';

        $o .= htmlspecialchars($row['name_short']);
        $t .= $row['name_short'];
        
        if ($style == 4)
        {
            $o .= '&quot;';
        }
        else
        {
            $o .= '</q>';
        }
        $t .= '"';
    }

    if ($row['k9data_id'] != null && strlen($row['k9data_id']) > 0 &&
            ($style == 0 || $style == 1))
    {
        $o .= ' <a href="http://www.k9data.com/pedigree.asp?ID=';
        $o .= $row['k9data_id'];
        $o .= '" target="_blank" title="K9Data Entry" class="dog_link">K9Data</a>';
    }

    if ($row['pedigree_id'] != null && strlen($row['pedigree_id']) > 0 &&
            ($style == 0 || $style == 1))
    {
        $ped_link = api_print_pedigree_link($pdo, $row['pedigree_id'], '', 0, false, 'dog_link');
        if ($ped_link['result'])
        {
            $o .= $ped_link['html'];
        }
    }

    if ($style == 2 || $style == 4 || ($style == 1 && $is_signed_in))
    {
        $date_b = $row['date_birth'];
        $date_d = $row['date_death'];

        $date_b = date('m/d/Y', strtotime($date_b));
        if ($date_d != null)
        {
            $date_d = str_replace('-00', '-01', $date_d);
            $date_d = strtotime($date_d);
        }
        else
        {
            $date_d = strtotime('1900-01-01');
        }

        $date_txt = " ($date_b - ";
        switch ($row['date_death_mask']) {
        case 0: // alive
            $date_txt .= 'present'; break;
        case 1: // not alive, ####-##-##
            $date_txt .= date('m/d/Y', $date_d); break;
        case 2: // not alive, ####-##-00
            $date_txt .= date('d/Y', $date_d); break;
        case 3: // not alive, ####-00-00
            $date_txt .= date('Y', $date_d); break;
        case 4: // not alive, 0000-00-00
            $date_txt .= 'unknown'; break;
        }
        $date_txt .= ")";
        $o .= $date_txt;
        $t .= $date_txt;
    }

    if ($is_signed_in && $style == 1)
    {
        $o .= ' <a class="edit" href="ourdogs.php?act=edit&id=';
        $o .= $row['id'];
        if ($return_to != 'ourdogs')
        {
            $o .= '&returnto=' . $return_to;
        }
        $o .= '">Edit'."</a>\r\n";
    }

    if ($style == 1)
    {
        $o .= '</dt>';
        $alive = $row['date_death_mask'] == 0;
        switch ($row['own_state']) {
        default:
        case 'NONE': $own_state = ''; break;
        case 'LW': $own_state = 'Live'.($alive ? 's' : 'd').' with *'; break;
        case 'LWP': $own_state = 'Live'.($alive ? 's' : 'd').' with pet home'; break;
        case 'OW': $own_state = 'Owned with *'; break;
        case 'OB': $own_state = 'Owned by *'; break;
        case 'AF': $own_state = $alive ? 'Available for foster home' : ''; break;
        case 'AS': $own_state = $alive ? 'Available for sale' : ''; break;
        case 'AA': $own_state = $alive ? 'Available for adoptive home' : ''; break;
        case 'A': $own_state = $alive ? 'Available for *' : ''; break;
        case 'X': $own_state = '*'; break;
        case 'SW': $own_state = 'Shared with *'; break;
        }

        if (strlen($own_state) > 0)
        {
            $own_state = stml_parse(str_replace('*', $row['own_by'], $own_state));
            $o .= "<dd>$own_state</dd>\r\n";
            $t .= "\n$own_state";
        }
    }

    return json_result(true, $t, $o, ['id' => $id]);
}


function api_print_titles($pdo, $title_str, $affix_pos = 'PRE', $show_abbr = true)
{
    $o = '';
    $t = '';
    $titles_assoc = [];

    if (strlen(trim($title_str)) == 0)
    {
        // empty input, empty output
        return json_result(true);
    }
    
    $affix_pos = strtoupper($affix_pos);

    $titles = explode(' ', $title_str);

    $title_m = '';
    $title_modifier_printed = false;
    foreach ($titles as $title)
    {
        // normalize input
        if (substr($title, -1, 1) == '.' ||
            substr($title, -1, 1) == ',' ||
            substr($title, -1, 1) == ';')
        {
            $title_x = strtoupper(substr($title, 0, strlen($title) - 1));
        }
        else
        {
            $title_x = strtoupper($title);
        }

        // store title modifiers
        if ($title_x == 'AM' ||
            $title_x == 'CAN' ||
            $title_x == 'AM/CAN' ||
            $title_x == 'CAN/AM' ||
            $title_x == '_')
        {
            $title_m = $title_x;
            $title_modifier_printed = false;
            continue;
        }

        // handle title modifiers
        switch ($title_m)
        {
        case '':
        case '_':
            $title_modifier = '';
            $descr_modifier = '';
            break;
        case 'AM/CAN':
        case 'CAN/AM':
            $title_modifier = 'Am./Can. ';
            $descr_modifier = ' (American and Canadian)';
            break;
        case 'CAN':
            $title_modifier = 'Can. ';
            $descr_modifier = ' (Canadian)';
            break;
        case 'AM':
            $title_modifier = 'Am. ';
            $descr_modifier = ' (American)';
            break;
        }

        // handle titles with ordinals
        $i = 1;
        $title_number = '1';
        while (ctype_digit(substr($title_x, -$i, 1)))
        {
            if ($i == 1)
            {
                $title_number = $title_x[strlen($title_x) - $i];
            }
            else
            {
                $title_number = $title_x[strlen($title_x) - $i]
                               .$title_number;
            }
            $title_x[strlen($title_x) - $i] = '#';
            $title_x = str_replace('##', '#', $title_x);
            $i++;
        }

        if ($show_abbr === false || array_search($affix_pos, ['PRE', 'POST']) === false)
        {
            // do not query database if results will be empty or unused
            $row = false;
        }
        else
        {
            // query
            $sql =
            'SELECT *
             FROM `titles`
             WHERE `abbr` = :abbr
             AND `type` = :type
             LIMIT 1';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['abbr' => $title_x, 'type' => $affix_pos]);
            $row = $stmt->fetch();
            $stmt = null;
        }

        // not in databse: result is input
        if ($row === false)
        {
            $row = ['abbr' => $title_x, 'type' => $affix_pos];
        }

        // restore titles with ordinals
        $row['abbr'] = str_replace('#', $title_number, $row['abbr']);
        $row['descr'] = str_replace('#', $title_number, isset($row['descr']) ? $row['descr'] : '');
        
        // store in $titles_assoc for API
        if (strlen($row['abbr']) > 0)
        {
            $titles_assoc[$row['abbr']] = $row['descr'];
        }

        // space before postfixes
        if ($affix_pos == 'POST')
        {
            $o .= ' ';
            $t .= ' ';
        }

        // print title modifier if stored
        if ($title_modifier_printed)
        {
            $title_modifier = '';
        }
        else
        {
            $title_modifier_printed = true;
        }

        $o .= htmlspecialchars($title_modifier);
        $t .= $title_modifier;

        // print titles
        if (strlen($row['descr']) > 0 && $show_abbr)
        {
            $o .= '<abbr title="'
               .htmlspecialchars($row['descr'].$descr_modifier)
               .'">'
               .htmlspecialchars($row['abbr'])
               .'</abbr>';
            $t .= $row['abbr'];
        }
        else
        {
            $o .= htmlspecialchars($row['abbr']);
            $t .= $row['abbr'];
        }

        // space after prefixes
        if ($affix_pos == 'PRE')
        {
            $o .= ' ';
            $t .= ' ';
        }
    }

    return json_result(true, $t, $o, ['titles' => $titles_assoc, 'type' => $affix_pos]);
}


// prints a pedigree link from the pedigrees database in one of two styles.
// Style 0: compact, for litters page
// Style 1: with dogs' names in anchor text, for pedigrees page
function api_print_pedigree_link($pdo, $id, $filter = '', $style = 1, $show_edit = false, $class = '')
{
    global $is_signed_in;

    $o = '';

    $sql =
    'SELECT PEDS.`id`, PEDS.`location`, PEDS.`date_birth`,
      DOGS.`name_short` AS `sire_name`,
      DOGS2.`name_short` AS `dam_name`
     FROM `pedigrees` AS PEDS
     INNER JOIN `dogs` AS DOGS
      ON PEDS.`sire_id` = DOGS.`id`
     INNER JOIN `dogs` AS DOGS2
      ON PEDS.`dam_id` = DOGS2.`id`
     WHERE PEDS.`id` = :id 
     LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(false, 'Not found.');
    }

    $id = $row['id'];

    $yr = substr($row['date_birth'], 0, 4);
    if ($style == 1)
    {
        $o .= "<dt>";
    }

    $o .= '<a ';
    if (strlen($class) > 0)
    {
        $o .= 'class="'.$class.'" ';
    }
    $o .= 'href="pedigrees/';
    $o .= $row['location'];
    $o .= '" target="_blank" title="';
    $o .= $row['sire_name'];
    $o .= ' and ';
    $o .= $row['dam_name'];
    $o .= ' Puppies\' Pedigree (';
    $o .= $yr;
    $o .= ')">';
    $o .= '<img src="/pdficon.png" class="pdficon" title="This document is in the Adobe PDF format." Alt="[PDF]" />';
    if ($style == 1)
    {
        $o .= "$row[sire_name] x $row[dam_name] Litter";
    }
    else
    {
        $o .= 'Pedigree';
    }
    $o .= '</a>';

    if ($show_edit && $is_signed_in)
    {
        $o .= ' <a class="edit" href="pedigrees.php?act=edit&id=';
        $o .= $row['id'];
        $o .= '">Edit Details</a>';
    }
    if ($style == 1) {
        $o .= '</dt>';
    }

    return json_result(true, '', $o, ['id' => $id]);
}

function api_get_dog_by_id($pdo, $id, $filter = '')
{
    $sql =
    'SELECT
     `id`, `name_full`, `name_short`, `own_cat`, `own_by`,
     `own_state`, `honor_cat`, `gender`, `date_death_mask`,
     `titles_pre`, `titles_post`, `date_birth`, `date_death`,
     `sire_id`, `dam_id`, `pedigree_id`, `k9data_id`
     FROM `dogs`
     WHERE `id` = :id
     LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(false, 'Not found.');
    }

    return json_result(true, $row['name_full'], '', $row);
}

function api_get_pedigree_by_id($pdo, $id, $filter = '')
{
    $sql =
    'SELECT `id`, `location`, `active`, `date_birth`, `sire_id`, `dam_id`
     FROM `pedigrees`
     WHERE `id` = :id
     LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(false, 'Not found.');
    }

    return json_result(true, $row['location'], '', $row);
}

function api_get_stml_template($pdo, $q, $filter = '')
{
    $sql =
    'SELECT *
     FROM `stml_templates`
     WHERE `name` = :name
     LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $q]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(false, 'Not found.');
    }

    return json_result(true, '', '', ['id' => $row['id']]);
}

function api_find_k9data_page($pdo, $q, $filter = '')
{
    $query_result = k9data_post_search($q);

    return json_result(true, '', '', ['id' => +$query_result]);
}

function api_find_pedigree_file($pdo, $q, $filter = '')
{
    $q_x = explode(',', $q);
    if ($q_x === false || count($q_x) != 3)
    {
        return json_result(false, 'Invalid input.');
    }

    $sire = $q_x[0];
    $dam = $q_x[1];
    $date = $q_x[2];
    $sql =
    'SELECT `id`
     FROM `pedigrees`
     WHERE `sire_id` = :sire_id
       AND `dam_id` = :dam_id
       AND `date_birth` = :date_birth
     LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['sire_id' => $sire, 'dam_id' => $dam, 'date_birth' => $date]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(true, 'Not found.', '', ['id' => -1]);
    }

    return json_result(true, '', '', ['id' => $row['id']]);
}

function api_search_dog($pdo, $q, $filter = '', $limit = 10, $limit_offset = 0)
{
    if (strlen(trim($q)) == 0)
    {
        // empty input
        return json_result(false, 'Query required.');
    }

    $filter = strtoupper($filter);

    $q0 = $q;
    $q0 = str_replace('%', '\%', $q0);
    $q0 = str_replace('_', '\_', $q0);
    $q1 = "$q0%";
    $q2 = "% $q0%";

    $args = [
        'q1' => $q1, 'q2' => $q2,
        'limit' => $limit, 'limit_offset' => $limit_offset
    ];

    if ($filter == 'M')
    {
        $gender = 'MALE';
    }
    else if ($filter == 'F')
    {
        $gender = 'FEMALE';
    }
    else
    {
        $gender = false;
    }

    if ($gender === false)
    {
        $sql =
        'SELECT `id`, `name_full`
         FROM `dogs`
         WHERE (`name_full` LIKE :q1
          OR `name_full` LIKE :q2)
         ORDER BY `name_full` ASC
         LIMIT :limit_offset, :limit';
    }
    else
    {
        $sql =
        'SELECT `id`, `name_full`
         FROM `dogs`
         WHERE (`name_full` LIKE :q1
          OR `name_full` LIKE :q2)
          AND `gender` = :gender
         ORDER BY `name_full` ASC
         LIMIT :limit_offset, :limit';
        $args['gender'] = $gender;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($args);

    $o = '<ul>';
    $t = '';
    $results_assoc = [];
    while (($row = $stmt->fetch()) !== false)
    {
        $o .= '<li id="';
        $o .= htmlspecialchars($row['id']);
        $o .= '">';
        $o .= htmlspecialchars($row['name_full']);
        $o .= '</li>';
        $t .= $row['name_full'] . "\n";
        $results_assoc[$row['id']] = $row['name_full'];
    }
    $o .= '</ul>';
    $stmt = null;

    return json_result(true, $t, $o, [
        'q' => $q, 'filter' => $gender,
        'limit' => $limit, 'limit_offset' => $limit_offset,
        'results' => $results_assoc
    ]);
}

function hash_password1($pass)
{
    return md5($pass.'.fkl;uv0');
}

function api_session_account_login($pdo, $username, $password)
{
    $sql =
    'SELECT `id`, `username`, `first_name`, `last_name`, `access`
     FROM `accounts`
     WHERE `username` = :username
      AND `password` = :password
     LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => hash_password1($password)]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(false, 'Not found.');
    }

    return json_result(true, '', '', $row);
}

function api_session_account_check($pdo, $account_id)
{
    $sql =
    'SELECT `id`, `username`, `first_name`, `last_name`, `access`
     FROM `accounts`
     WHERE `id` = :id
     LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $account_id]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(false, 'Not found.');
    }

    return json_result(true, '', '', $row);
}

function api_session_start($pdo, $account_id, $time)
{
    return session_action_insert($pdo, 'sessions',
        [ 'user_id' => $account_id,
          'start' => db_date($time),
          'open' => 1 ],
        false);
}

function api_session_end($pdo, $user_id, $sess_id, $time)
{
    return session_action_update($pdo, 'sessions',
        [ 'user_id' => $user_id,
          'id' => $sess_id ],
        [ 'open' => 0,
          'end' => db_date($time) ],
        false);
}

function api_pages_find($pdo, $file_name, $filter = '')
{
    $sql = 
    'SELECT `id`, `location`, `title`, `anchor`, `index`
     FROM `pages`
     WHERE `location` = :location
     LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['location' => $file_name]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(false, 'Not found.');
    }

    return json_result(true, '', '', $row);
}

function api_pages_list($pdo, $q = '', $filter = '', $limit = 25, $limit_offset = 0)
{
    $sql = 
    'SELECT `id`, `location`, `title`, `anchor`, `index`, `search_chfreq`, `search_priority`
     FROM `pages`
     WHERE `index` > 0
     ORDER BY `index` ASC
     LIMIT :limit_offset, :limit';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['limit' => $limit, 'limit_offset' => $limit_offset]);

    $o = '';
    $t = '';
    $results_assoc = [];
    while (($row = $stmt->fetch()) !== false)
    {
        $o .= '<a href="./';
        $o .= htmlspecialchars($row['location']);
        $o .= '.php" title="';
        $o .= htmlspecialchars($row['title']);
        $o .= '">';
        $o .= htmlspecialchars($row['anchor']);
        $o .= '</a>';
        $t .= $row['anchor']."\n";
        $results_assoc[$row['id']] = $row;
    }
    $stmt = null;

    return json_result(true, $t, $o, [
        'q' => $q, 'filter' => $filter,
        'limit' => $limit, 'limit_offset' => $limit_offset,
        'results' => $results_assoc
    ]);
}

function api_dogs_list($pdo, $q = '', $filter = '', $limit = 25, $limit_offset = 0, $where = '1', $order_by = '`id` ASC', $header_level = 3, $header_text = '', $return_to = 'ourdogs')
{
    global $is_signed_in;


    $sql =
    "SELECT `id`, `name_short`
     FROM `dogs`
     WHERE $where
     ORDER BY $order_by, `name_short` ASC
     LIMIT :limit_offset, :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['limit' => $limit, 'limit_offset' => $limit_offset]);

    $o = '';
    $t = '';
    $results_assoc = [];
    $count = 0;
    while (($row = $stmt->fetch()) !== false)
    {
        if ($count == 0)
        {
            if ($header_level >= 1)
            {
                $o .= "<h$header_level>";
                $o .= htmlspecialchars($header_text);
                $o .= "</h$header_level>";
                $o .= "<dl>";
            }

            if ($is_signed_in)
            {
                $o .= ' <p><a class="edit" href="';
                $o .= 'ourdogs.php?act=add';
                if ($return_to != 'ourdogs')
                {
                    $o .= "&returnto=$return_to";
                }
                $o .= '">Create New</a></p>';
            }
        }

        $dog_obj = api_print_dog($pdo, $row['id'], '', 1, $return_to);
        $results_assoc[$row['id']] = $dog_obj;
        $o .= '<div class="list_element">'.$dog_obj['html'].'</div>';
        $t .= $dog_obj['text']."\n";

        $count++;
    }

    if ($count > 0)
    {
        $o .= "</dl>";
    }

    return json_result(true, $t, $o, [
        'q' => $q, 'filter' => $filter,
        'limit' => $limit, 'limit_offset' => $limit_offset,
        'results' => $results_assoc
    ]);
}

function api_litters_list($pdo, $q = '', $filter = '', $limit = 25, $limit_offset = 0, $where = '1', $order_by = '`id` ASC')
{
    global $is_signed_in;

    $sql =
    "SELECT `id`
     FROM `litters`
     WHERE $where
     ORDER BY $order_by
     LIMIT :limit_offset, :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['limit' => $limit, 'limit_offset' => $limit_offset]);

    $o = '';
    $t = '';
    $results_assoc = [];
    $count = 0;
    while (($row = $stmt->fetch()) !== false)
    {
        if ($count == 0)
        {
            if ($is_signed_in)
            {
                $o .= '        <p><a class="edit" href="litters.php?act=add">Create New</a></p>'."\r\n";
            }
        }
        $litter_obj = api_get_litter_by_id($pdo, $row['id']);
        $o .= '<div class="list_element">'.$litter_obj['html'].'</div>';
        $results_assoc[$row['id']] = $litter_obj;
        $count++;
    }
    $stmt = null;

    return json_result(true, $t, $o, [
        'q' => $q, 'filter' => $filter,
        'limit' => $limit, 'limit_offset' => $limit_offset,
        'results' => $results_assoc
    ]);
}

function api_get_litter_by_id($pdo, $id, $filter = '')
{
    global $is_signed_in;

    $o = '';
    $t = '';
    $type_noun = '';
    $born_verb = '';

    $sql =
    'SELECT `id`, `born`, `desc_short`, `desc_long`, `date_birth`, `pedigree_id`, `own_by`, `sire_id`, `dam_id`, `count_males`, `count_females`, `active`
     FROM `litters`
     WHERE `id` = :id
     LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    $stmt = null;

    if ($row === false)
    {
        // empty result
        return json_result(false, 'Not found.');
    }

    $born = intval($row['born']);
    if ($born == 1)
    { // BORN
        $born_verb = 'born';
        $type_noun = 'Litter ';
    }
    elseif ($born == 2)
    { // NONLITTER
        $born_verb = 'Born';
        $type_noun = '';
    }
    elseif ($born == 3)
    { // SPECIALNOTE
        if ($row['desc_long'] != null && strlen($row['desc_long']) > 0)
        {
            $o .= '        <p><i>';
            $o .= stml_parse($row['desc_long']);
            $o .= "</i>\r\n";
        }

        if ($is_signed_in)
        {
            $o .= '          <a class="edit" href="litters.php?act=edit&id=';
            $o .= $row['id'];
            $o .= '">Edit</a>';
            $o .= "\r\n";
        }

        $o .= "      </p>\r\n";
        return $o;
    }
    else
    { // DUE
        $born_verb = 'due';
        $type_noun = 'Litter ';
    }
    $born_date = date('F j, Y', strtotime($row['date_birth']));

    $o .= '      <p class="litter">'."\r\n";
    $o .= '        <span class="litter_head"><b>';
    $o .= "$type_noun$born_verb $born_date:</b>\r\n";
    if ($row['pedigree_id'] != null && strlen($row['pedigree_id']) > 0)
    {
        $ped_link = api_print_pedigree_link($pdo, $row['pedigree_id'], '', 0);
        if ($ped_link['result'])
        {
            $o .= $ped_link['html'];
        }
    }

    if ($is_signed_in)
    {
        $o .= '          <a class="edit" href="litters.php?act=edit&id=';
        $o .= $row['id'];
        $o .= '">Edit</a>';
    }

    $o .= "        </span>\r\n";

    if ($row['own_by'] != null && strlen($row['own_by']) > 0)
    {
        $o .= '        <span class="litter_note"><b>Owned by:</b> ';
        $o .= stml_parse($row['own_by']);
        $o .= "</span>\r\n";
    }

    if ($born == 1)
    {
        $litter_text = number_to_words($row['count_males'], 1).' male'.plural($row['count_males']).' and '.
                       number_to_words($row['count_females']).' female'.plural($row['count_females']);
        if ($row['desc_short'] != null && strlen($row['desc_short']) > 0)
        {
            $litter_text .='; '.stml_parse($row['desc_short']);
        }

        $o .= '        <span class="litter_pups"><b>Litter:</b> ';
        $o .= $litter_text;
        $o .= "</span>\r\n";
    }

    $dog_obj1 = api_print_dog($pdo, $row['sire_id'], '', 0);
    $dog_obj2 = api_print_dog($pdo, $row['dam_id'], '', 0);
    $o .= '        <span class="litter_sire"><b>Sire:</b> ';
    $o .= $dog_obj1['html'];
    $o .= "</span>\r\n";
    $o .= '        <span class="litter_dam"><b>Dam:</b> ';
    $o .= $dog_obj2['html'];
    $o .= "</span>\r\n";
  
    if ($row['desc_long'] != null && strlen($row['desc_long']) > 0)
    {
        $o .= '        <span class="litter_note"><b>Note:</b> ';
        $o .= stml_parse($row['desc_long']);
        $o .= "</span>\r\n";
    }

    $o .= "      </p>\r\n";

    return json_result(true, '', $o, $row);
}

function api_pedigrees_list($pdo, $q = '', $filter = '', $limit = 25, $limit_offset = 0, $where = '1', $order_by = '`id` ASC', $year_headers = false)
{
    global $is_signed_in;

    $sql =
    "SELECT `id`, `date_birth`
     FROM `pedigrees`
     WHERE $where
     ORDER BY $order_by
     LIMIT :limit_offset, :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['limit' => $limit, 'limit_offset' => $limit_offset]);

    $dl_open = false;
    $h_year = [];
    $o = '';
    $t = '';
    $results_assoc = [];
    while (($row = $stmt->fetch()) !== false)
    {
        $yr = substr($row['date_birth'], 0, 4);
        if (!array_key_exists($yr, $h_year))
        {
            if ($dl_open)
            {
                $o .= "</dl>";
                $dl_open = false;
            }

            if ($year_headers)
            {
                $o .= "<h3>$yr</h3>\r\n";
            }

            $h_year[$yr] = true;

            if ($is_signed_in)
            {
                $o .= '<p><a class="edit" href="pedigrees.php?act=add">Create New</a></p>';
            }
        }

        if (!$dl_open)
        {
            $o .= "<dl>";
            $dl_open = true;
        }

        $ped_obj = api_print_pedigree_link($pdo, $row['id'], '', 1, true);
        $o .= '<div class="list_element">'.$ped_obj['html'].'</div>';
        $results_assoc[$row['id']] = $ped_obj;
    }
    $stmt = null;

    if ($dl_open)
    {
        $o .= "</dl>";
    }

    return json_result(true, $t, $o, [
        'q' => $q, 'filter' => $filter,
        'limit' => $limit, 'limit_offset' => $limit_offset,
        'results' => $results_assoc
    ]);
}

function api_links_list($pdo, $q = '', $filter = '', $limit = 25, $limit_offset = 0)
{
    global $is_signed_in;

    $sql =
    'SELECT *
     FROM `links`
     WHERE `index` > 0
     ORDER BY `index` ASC
     LIMIT :limit_offset, :limit';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['limit' => $limit, 'limit_offset' => $limit_offset]);
    $link_count = $stmt->rowCount();

    $dl_open = false;
    $o = '';
    $t = '';
    $results_assoc = [];
    while (($row = $stmt->fetch()) !== false)
    {
        if (!$dl_open)
        {
            $o .= "<dl>";
            $dl_open = true;
        }

        $location = $row['location'];
        $title = $row['title'];

        if (strtolower(substr($location, 0, 8)) == 'https://')
        {
            if (substr_count($location, '/') == 2)
            {
                $location .= '/';
            }
        }
        else
        {
            if (substr_count($location, '/') == 0)
            {
                $location .= '/';
            }
            $location = "https://$location";
        }

        $location_friendly = substr($location, 8);
        if (substr_count($location_friendly, '/') == 1)
        {
            $location_friendly = substr($location_friendly, 0, strlen($location_friendly) - 1);
        }

        $t .= $location."\n";
        $o .= '<dt><a href="';
        $o .= htmlspecialchars($location);
        $o .= ' target="_blank" title="';
        $o .= htmlspecialchars($title);
        $o .= '">';
        $o .= htmlspecialchars($title);
        $o .='</a></dt><dd>URL: ';
        $o .= htmlspecialchars($location_friendly);
        $o .= '</dd>';

        if ($is_signed_in)
        {
            if ($row['index'] > 1)
            {
                $o .= '<a class="edit" href="links.php?act=up&id=';
                $o .= $row['id'];
                $o .= '">Move Up</a>';
            }
            if ($row['index'] < $link_count)
            {
                $o .= '<a class="edit" href="links.php?act=down&id=';
                $o .= $row['id'];
                $o .= '">Move Down</a>';
            }
            if ($link_count > 1)
            {
                $o .= ' | ';
            }
            $o .= '<a class="edit" href="links.php?act=edit&id=';
            $o .= $row['id'];
            $o .= '">Edit</a>';
        }

        $results_assoc[$row['id']] = $row;
    }
    $stmt = null;

    if ($dl_open)
    {
        $o .= "</dl>";
    }

    return json_result(true, $t, $o, [
        'q' => $q, 'filter' => $filter,
        'limit' => $limit, 'limit_offset' => $limit_offset,
        'results' => $results_assoc
    ]);
}

function api_litter_insert($pdo, $params, $act_descr = '')
{
    return session_action_insert($pdo, 'litters', $params, true, $act_descr);
}

function api_litter_update($pdo, $id, $params, $act_descr = '')
{
    return session_action_update($pdo, 'litters', [ 'id' => $id ], $params, true, $act_descr);
}

function api_litter_delete($pdo, $id, $act_descr = '')
{
    return session_action_delete($pdo, 'litters', [ 'id' => $id ], true, $act_descr);
}

function api_dog_insert($pdo, $params, $act_descr = '')
{
    return session_action_insert($pdo, 'dogs', $params, true, $act_descr);
}

function api_dog_update($pdo, $id, $params, $act_descr = '')
{
    return session_action_update($pdo, 'dogs', [ 'id' => $id ], $params, true, $act_descr);
}

function api_dog_delete($pdo, $id, $act_descr = '')
{
    return session_action_delete($pdo, 'dogs', [ 'id' => $id ], true, $act_descr);
}

function api_pedigree_insert($pdo, $params, $act_descr = '')
{
    return session_action_insert($pdo, 'pedigrees', $params, true, $act_descr);
}

function api_pedigree_update($pdo, $id, $params, $act_descr = '')
{
    return session_action_update($pdo, 'pedigrees', [ 'id' => $id ], $params, true, $act_descr);
}

function api_pedigree_delete($pdo, $id, $act_descr = '')
{
    return session_action_delete($pdo, 'pedigrees', [ 'id' => $id ], true, $act_descr);
}
