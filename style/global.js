$(document).ready(function() {
  /*if ($.browser.msie) {
    // quotes, IE
    $('q')
    .before('&#147;')
    .after('&#148;');
    // side button font size
    $('div.nav a').each(function(){
      $(this)[0].style.fontSize = '11pt';
    });
  }*/
  
  $('input.input_date').each(function() {
    var name = $(this).attr('name');
    var datemask = $(this).attr('datemask');
    $(this).attr('id', name);
    var month = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var today;
    if ($(this).val().length > 0) {
      var v = $(this).val();
      if (v == '0000-00-00')
        v = '0000-01-01';
      else if (v.substr(5, 5) == '00-00')
        v = v.substr(0, 5) + '01-01';
      else if (v.substr(8, 2) == '00')
        v = v.substr(0, 8) + '01';
      today = new Date(v); // set to default value for this date-- the value in the text box
      if (today.getFullYear() <= 1900) {
        v = new Date().getFullYear() + v.substr(4, 6);
        today = new Date(v);
      }
    } else {
      today = new Date();
    }
    var mo_options = '';
    var mo_selected = false;
    if (datemask > 0) {
      var select = (datemask >= 3);
      if (select)
        mo_selected = true;
      mo_options += '<option ' + (select ? 'selected="selected" ' : '') + 'value="00">--</option>';
    }
    for (var i = 1; i <= 12; i++) {
      var select = (mo_selected ? false : (today.getMonth() + 1) == i);
      if (select)
        mo_selected = true;
      mo_options += '<option ' + (select ? 'selected="selected" ' : '') + 'value="' + '00'.substr(0, 2 - i.toString().length) + i.toString() + '">' + month[i-1] + '</option>';
    }
    var dy_options = '';
    var dy_selected = false;
    if (datemask > 0) {
      var select = (datemask >= 2);
      if (select)
        dy_selected = true;
      dy_options += '<option ' + (select ? 'selected="selected" ' : '') + 'value="00">--</option>';
    }
    for (var i = 1; i <= 31; i++) {
      var select = (dy_selected ? false : (today.getDate() + 1) == i);
      if (select)
        dy_selected = true;
      dy_options += '<option ' + (select ? 'selected="selected" ' : '') + 'value="' + '00'.substr(0, 2 - i.toString().length) + i.toString() + '">' + i.toString() + '</option>';
    }
    var yr_options = '';
    var yr_selected = false;
    if (datemask > 0) {
      var select = (datemask >= 4);
      if (select)
        yr_selected = true;
      yr_options += '<option ' + (select ? 'selected="selected" ' : '') + 'value="0000">----</option>';
    }
    var yr_base = today.getFullYear();
    for (var i = yr_base - 40; i < yr_base + 10; i++) {
      var select = (yr_selected ? false : yr_base == i);
      if (select)
        yr_selected = true;
      yr_options += '<option ' + (select ? 'selected="selected" ' : '') + 'value="' + i.toString() + '">' + i.toString() + '</option>';
    }
    var input_html =
    '<div id="' + name + '_wrapper" class="multi_input_wrapper"><div class="input_date_wrapper">' +
    '<select class="input_date_field input_date_mo" id="' + name + '_field_mo" type="text">' +
    mo_options +
    '</select>/' +
    '<select class="input_date_field input_date_dy" id="' + name + '_field_dy" type="text">' +
    dy_options +
    '</select>/' +
    '<select class="input_date_field input_date_yr" id="' + name + '_field_yr" type="text">' +
    yr_options +
    '</select>' +
    '</div></div>';
    $(this).after(input_html);
    $(this).hide();
    $('#' + name + '_field_mo').change(function() {
      var date = new Date($('#' + name + '_field_yr').val() + '-' +
                          $(this).val() + '-' +
                          $('#' + name + '_field_dy').val());
      var molen = [31,28 + (date.getFullYear() % 4 == 0) ? 1 : 0,31,30,31,30,31,31,30,31,30,31];
      var dayopts = [
        '<option value="29">29</option>',
        '<option value="30">30</option>',
        '<option value="31">31</option>'];
      for (var i = 29; i < 32; i++) {
        if (i <= molen[date.getMonth()]) {
          if ($('#' + name + '_field_dy option[value=' + i + ']').length == 0) {
            $('#' + name + '_field_dy').append(dayopts[i - 29]);
          }
        } else {
          $('#' + name + '_field_dy option[value=' + i + ']').remove();
        }
      }
    });
    
    $('#' + name + '_field_mo, #' + name + '_field_dy, #' + name + '_field_yr').change(function() {
      $('input[name=' + name + ']').val(
                  $('#' + name + '_field_yr').val() + '-' +
                  $('#' + name + '_field_mo').val() + '-' +
                  $('#' + name + '_field_dy').val());
    });
  });
  
  $('input.input_dog').each(function() {
    var is_set = false;
    var ajax_appending = false;
    var name = $(this).attr('name');
    $(this).attr('id', name);
    var input_html =
    '<div id="' + name + '_wrapper" class="multi_input_wrapper">' +
    '<input class="input_dog_field" id="' + name + '_field" autocomplete="off" type="text" value="">' +
    '</div>' +
    '<div class="input_dog_box" id="' + name + '_box"><ul></ul></div>';
    $(this).after(input_html);
    $(this).hide();
    if (Number($(this).val()) > 0) {
      is_set = true;
      
      $.ajax({
        async: true,
        cache: false,
        dataType: 'text',
        error: function (xhr, result, exception) {
          alert(result + ': ' + exception.toString());
        },
        success: function (text, result, xhr) {
          var curval = text;
          $('#' + name + '_field').val(curval);
        },
        type: 'GET',
        url: '/util/a.php?act=getdogbyid&q=' + $(this).val()
      });
      
      ajax_appending = true;
      $.ajax({
        async: true,
        cache: false,
        complete: function (xhr, result) {
          ajax_appending = false;
        },
        dataType: 'html',
        error: function (xhr, result, exception) {
          ajax_appending = false;
          alert(result + ': ' + exception.toString());
        },
        success: function (html, result, xhr) {
          if (ajax_appending) {
            ajax_appending = false;
            if (html.length > 0) {
              html =
              '<div id="' + name + '_preview" class="input_preview">' +
              '<span class="x" title="remove">x</span>' +
              html + '</div>';
              $('#' + name + '_wrapper').after(html);
            }
          }
        },
        type: 'GET',
        url: '/util/a.php?act=printdog&q=' + $(this).val()
      });
    }
    var list, lastval, ajax_active;
    var box = $('#' + name + '_box');
    $('#' + name + '_field').blur(function() {
      setTimeout(function(){box.hide();}, 1000);
    });
    
    $('#' + name + '_field').keyup(function(e) {
      if (is_set) {
        $('#' + name).val(0);
        is_set = false;
        $('#' + name + '_preview').remove();
      }
      var val = $(this).val();
      var gender = $('#' + name).attr('gender');
      if (val.length == 0) {
        box.hide();
        list = null;
        return true;
      } else {
        box.show();
      }
      
      if (!list) {
        if (!ajax_active) {
          ajax_active = true;
          $.ajax({
            async: true,
            cache: false,
            complete: function (xhr, result) {
              ajax_active = false;
            },
            dataType: 'html',
            error: function (xhr, result, exception) {
              box.hide();
              alert(result + ': ' + exception.toString());
            },
            success: function (html, result, xhr) {
              if (html.length > 0) {
                var li = $(html).find('li');
                list = new Array($(li).length);
                $(li).each(function(index) {
                  list[index] = this;
                });
              } else {
                box.hide();
              }
            },
            type: 'GET',
            url: '/util/a.php?act=getdog&q=' + val + '&f=' + gender
          });
        }
      }
      
      if (!list) {
        box.hide();
      } else {
        box.find('span').remove();
        box.find('ul').show();
        var ul = box.find('ul');
        $(ul).empty();
        var c = 0;
        for (var i = 0; i < list.length; i++) {
          if ($(list[i]).text().replace(/'s?/ig, '').match(new RegExp('(.* )?' + val.replace(/'s?/ig, '') + '.*', 'i'))) {
            var text = $(list[i]).html();
            var insert = '<li id="' + $(list[i]).attr('id') + '">';
            var words = text.split(' ');
            var match_words = val.toLowerCase().split(' ');
            for (var w = 0; w < words.length; w++) {
              var matches = -1;
              for (var m = 0; m < match_words.length; m++) {
                if (match_words[m].length > 0) {
                  if (words[w].replace(/'s?/ig, '').substr(0, match_words[m].replace(/'s?/ig, '').length).toLowerCase() == match_words[m].replace(/'s?/ig, '')) {
                    matches = m;
                  } 
                }
              }
              if (matches >= 0) {
                insert += '<span>';
                insert += words[w].substr(0, match_words[matches].replace(/'s?/ig, '').length);
                insert += '</span>';
                insert += words[w].substr(match_words[matches].replace(/'s?/ig, '').length);
              } else {
                insert += words[w];
              }
              insert += ' ';
            }
            insert += '</li>';
            $(ul).append(insert);
            c++;
            if (c >= 5) {
              break;
            }
          }
        }
        if (c == 0) {
          box.find('ul').hide();
          box.append('<span>No dogs found.</span>');
        }
      }
    });
    
    $(document).on('click', '#' + name + '_preview span.x', function() {
      is_set = false;
      $('#' + name + '_field').val('');
      $('#' + name + '_preview').remove();
    });
    
    $(document).on('click', '#' + name + '_box ul li', function() {
      var set_id = $(this).attr('id');
      $('#' + name + '_field').val($(this).text());
      $('#' + name).val(set_id);
      is_set = true;
      box.hide();
      
      ajax_appending = true;
      $.ajax({
        async: true,
        cache: false,
        complete: function (xhr, result) {
          ajax_appending = false;
        },
        dataType: 'html',
        error: function (xhr, result, exception) {
          ajax_appending = false;
          alert(result + ': ' + exception.toString());
        },
        success: function (html, result, xhr) {
          if (ajax_appending) {
            ajax_appending = false;
            if (html.length > 0) {
              html =
              '<div id="' + name + '_preview" class="input_preview">' +
              '<span class="x" title="remove">x</span>' +
              html + '</div>';
              $('#' + name + '_wrapper').after(html);
            }
          }
        },
        type: 'GET',
        url: '/util/a.php?act=printdog&q=' + set_id
      });
    });
  });
  
  $('input.input_ped').each(function() {
    var is_set = false;
    var name = $(this).attr('name');
    var input_html =
    '<div id="' + name + '_wrapper" class="multi_input_wrapper"><div class="input_ped_wrapper">' +
    '<input class="input_ped_field" readonly="readonly" id="' + name + '_field" type="text" value=""></input>' +
    '<a class="edit input_ped_finder" href="#" id="' + name + '_finder">Find</a>' +
    '</div></div>';
    $(this).after(input_html);
    $(this).hide();
    if (Number($(this).val()) > 0) {
      is_set = true;
      
      $.ajax({
        async: true,
        cache: false,
        dataType: 'text',
        error: function (xhr, result, exception) {
          alert(result + ': ' + exception.toString());
        },
        success: function (text, result, xhr) {
          var curval = text;
          $('#' + name + '_field').val(curval);
        },
        type: 'GET',
        url: '/util/a.php?act=getpedbyid&q=' + $(this).val()
      });
      
      ajax_appending = true;
      $.ajax({
        async: true,
        cache: false,
        complete: function (xhr, result) {
          ajax_appending = false;
        },
        dataType: 'html',
        error: function (xhr, result, exception) {
          ajax_appending = false;
          alert(result + ': ' + exception.toString());
        },
        success: function (html, result, xhr) {
          if (ajax_appending) {
            ajax_appending = false;
            if (html.length > 0) {
              html =
              '<div id="' + name + '_preview" class="input_preview">' +
              '<span class="x" title="remove">x</span>' +
              html + '</div>';
              $('#' + name + '_wrapper').after(html);
            }
          }
        },
        type: 'GET',
        url: '/util/a.php?act=printped&q=' + $(this).val()
      });
    }
    
    $(document).on('click', '#' + name + '_finder', function() {
      is_set = false;
      $('#' + name + '_field').val('');
      $('#' + name + '_preview').remove();
      
      var query = $('.sire_id_for_' + name).val() + ',' +
                  $('.dam_id_for_' + name).val() + ',' +
                  $('.date_birth_for_' + name).val();
      $.ajax({
        async: true,
        cache: false,
        dataType: 'text',
        error: function (xhr, result, exception) {
          alert(result + ': ' + exception.toString());
        },
        success: function (text, result, xhr) {
          var ped_id = Number(text);
          if (ped_id > 0) {
            is_set = true;
            $('input[name='+name+']').val(ped_id);
            $.ajax({
              async: true,
              cache: false,
              dataType: 'text',
              error: function (xhr, result, exception) {
                alert(result + ': ' + exception.toString());
              },
              success: function (text, result, xhr) {
                var curval = text;
                $('#' + name + '_field').val(curval);
              },
              type: 'GET',
              url: '/util/a.php?act=getpedbyid&q=' + ped_id
            });
            
            ajax_appending = true;
            $.ajax({
              async: true,
              cache: false,
              complete: function (xhr, result) {
                ajax_appending = false;
              },
              dataType: 'html',
              error: function (xhr, result, exception) {
                ajax_appending = false;
                alert(result + ': ' + exception.toString());
              },
              success: function (html, result, xhr) {
                if (ajax_appending) {
                  ajax_appending = false;
                  if (html.length > 0) {
                    html =
                    '<div id="' + name + '_preview" class="input_preview">' +
                    '<span class="x" title="remove">x</span>' +
                    html + '</div>';
                    $('#' + name + '_wrapper').after(html);
                  }
                }
              },
              type: 'GET',
              url: '/util/a.php?act=printped&q=' + ped_id
            });
          } else {
            var e = '';
            if (ped_id <= 0)
              e = 'No pedigree file found matching the sire, dam, and birthdate. Those must be the same as the ones stored with the pedigree file.';
            var new_html =
            '<div id="' + name + '_preview" class="input_preview input_preview_error">' +
            '<span class="x" title="hide">x</span>' +
            e + '</div>';
            $('#' + name + '_wrapper').after(new_html);
          }
        },
        type: 'GET',
        url: '/util/a.php?act=findpedfile&q=' + query
      });
    });
    
    $(document).on('click', '#' + name + '_preview span.x', function() {
      is_set = false;
      $('#' + name + '_field').val('');
      $('#' + name + '_preview').remove();
    });
  });
  
  $('input.input_k9data').each(function() {
    var is_set = false;
    var k9data_id = Number($(this).val());
    var name = $(this).attr('name');
    var input_html =
    '<div id="' + name + '_wrapper" class="multi_input_wrapper"><div class="input_k9data_wrapper">' +
    '<input class="input_k9data_field" id="' + name + '_field" type="text"' +
    'value=""></input>' +
    '<a class="edit input_k9data_finder" href="#" id="' + name + '_finder">Find</a>' +
    '</div></div>';
    $(this).after(input_html);
    $(this).hide();
    if (k9data_id > 0) {
      is_set = true;
      $('#' + name + '_field').val(k9data_id);
      var html_follow =
      '<br id="' + name + '_break" /><a id="' + name + '_follow" class="edit" ' +
      'href="http://www.k9data.com/pedigree.asp?ID=' + k9data_id + '" ' +
      'target="_blank">Test Link</a>' +
      '<a id="' + name + '_remove" class="edit" ' +
      'href="#">Remove</a>';
      $('#' + name + '_finder').after(html_follow);
    }
    
    $(document).on('click', '#' + name + '_finder', function() {
      is_set = false;
      $('#' + name + '_field').val('');
      $('#' + name + '_break').remove();
      $('#' + name + '_follow').remove();
      $('#' + name + '_remove').remove();
      $('#' + name + '_preview').remove();
      
      var query = $('.dog_name_for_' + name).val();
      $.ajax({
        async: true,
        cache: false,
        dataType: 'text',
        error: function (xhr, result, exception) {
          alert(result + ': ' + exception.toString());
        },
        success: function (text, result, xhr) {
          var k9data_id = Number(text);
          if (k9data_id > 0) {
            is_set = true;
            $('input[name='+name+']').val(k9data_id);
            $('#' + name + '_field').val(k9data_id);
            var html_follow =
            '<br id="' + name + '_break" /><a id="' + name + '_follow" class="edit" ' +
            'href="http://www.k9data.com/pedigree.asp?ID=' + k9data_id + '" ' +
            'target="_blank">Test Link</a>' +
            '<a id="' + name + '_remove" class="edit" ' +
            'href="#">Remove</a>';
            $('#' + name + '_finder').after(html_follow);
          } else {
            var e = '';
            if (k9data_id == 0)
              e = 'No dogs found matching the "Dog AKC Name" field. Make sure the name above is the ' +
            'K9DATA has.';
            else if (k9data_id < 0)
              e = 'Multiple dogs found matching the "Dog AKC Name" field. Make sure the name above is the ' +
            'K9DATA has.';
            var new_html =
            '<div id="' + name + '_preview" class="input_preview input_preview_error">' +
            '<span class="x" title="hide">x</span>' +
            e + '</div>';
            $('#' + name + '_wrapper').after(new_html);
          }
        },
        type: 'GET',
        url: '/util/a.php?act=findk9datapage&q=' + query
      });
    });
    
    $('#' + name + '_field').change(function () {
      var k9data_id = Number($(this).val());
      $('#' + name + '_break').remove();
      $('#' + name + '_follow').remove();
      $('#' + name + '_remove').remove();
      if (k9data_id > 0) {
        $('input[name='+name+']').val(k9data_id);
        var html_follow =
        '<br id="' + name + '_break" /><a id="' + name + '_follow" class="edit" ' +
        'href="http://www.k9data.com/pedigree.asp?ID=' + k9data_id + '" ' +
        'target="_blank">Test Link</a>' +
        '<a id="' + name + '_remove" class="edit" ' +
        'href="#">Remove</a>';
        $('#' + name + '_finder').after(html_follow);
      } else {
        $('input[name='+name+']').val('');
      }
    });
    
    $(document).on('click', '#' + name + '_remove, #' + name + '_preview span.x', function() {
      is_set = false;
      $('input[name='+name+']').val('');
      $('#' + name + '_field').val('');
      $('#' + name + '_break').remove();
      $('#' + name + '_follow').remove();
      $('#' + name + '_remove').remove();
      $('#' + name + '_preview').remove();
    });
  });
  
  $('select[name=litter_verb]').change(function() {
    if ($(this).val() == '0') {
      $('label[for=litter_date]').text('Date Due:');
      $('div#sect_born').slideUp();
      $('select[name=count_males]').val(-1);
      $('select[name=count_females]').val(-1);
      $('input[name=desc_short]').val('');
    } else {
      $('label[for=litter_date]').text('Date Born:');
      $('div#sect_born').slideDown();
      $('select[name=count_males]').val(0);
      $('select[name=count_females]').val(0);
    }
  });
  
  $('select[name=dog_own_cat]').change(function() {
    if ($(this).val() == 'PAST') {
      $('select[name=dog_past]').val(1);
      $('div#sect_died').slideDown();
      $('input#date_death_field_mo').focus();
    }
  });
  
  $('select[name=dog_past]').change(function() {
    if ($(this).val() == 1) {
      $('div#sect_died').slideDown();
      $('input#date_death_field_mo').focus();
    } else {
      $('div#sect_died').slideUp();
    }
  });
  
  $('select[name=dog_own_state]').change(function() {
    switch ($(this).val()) {
      case 'LW':
        $('label[for=own_by]').text('Live' + ($('select[name=dog_own_cat]').val() == 'PAST' ? 'd' : 's') + ' with:');
        break;
      case 'SW':
        $('label[for=own_by]').text('Shared with:');
        break;
      case 'OW':
        $('label[for=own_by]').text('Owned with:');
        break;
      case 'OB':
        $('label[for=own_by]').text('Owned by:');
        break;
      case 'A':
        $('label[for=own_by]').text('Available for:');
        break;
      case 'X':
        $('label[for=own_by]').text('Custom Subtext:');
        break;
      default:
      case 'LWP':
      case 'AF':
      case 'AS':
      case 'NONE':
        $('div#sect_ob').slideUp();
        $('input[name=own_by]').val('');
        return;
    }
    $('div#sect_ob').slideDown();
    $('input[name=own_by]').focus();
  });
  
  $('input.cancel').click(function() {
    window.location = $(this).attr('href');
    return false;
  });
  
  $('a#image_more').click(function() {
    var next = Number($(this).attr('value')) + 1;
    var input_html =
    '<label for="desc_short_' + next + '">Title:</label>'+
    '<input name="desc_short_' + next + '" type="text" maxlength="50" value="">'+
    '<label for="desc_long_' + next + '">Subtext:</label>'+
    '<input name="desc_long_' + next + '" class="long" type="text" maxlength="100" value="">'+
    '<label for="desc_time_' + next + '">Taken on:</label>'+
    '<input name="desc_time_' + next + '" type="text" maxlength="50" value="">'+
    '<label for="active_' + next + '">Visible:</label>'+
    '<select name="active_' + next + '" class="short">'+
      '<option value="1" selected="selected">Yes</option>'+
      '<option value="0">No</option>'+
    '</select>'+
    '<label for="image_' + next + '">Image file:</label>'+
    '<div class="multi_input_wrapper">'+
      '<input name="image_' + next + '" class="input_file" type="file" value="">'+
    '</div>'+
    '<small>File type: Image; Maximum size: 512 MB</small>'+
    '<br />';
    $(this).attr('value', next);
    $('input#img_count').val(next);
    var input = $(input_html);
    input.hide();
    $(this).before(input);
    input.slideDown();
    $('input[name=desc_short_' + next + ']').focus();
  });
});