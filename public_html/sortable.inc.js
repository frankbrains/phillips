$(document).ready(function() {
  $('table.striped').each(function() {
    $(this).bind('stripe', function() {
      var rowIndex = 0;
      $('tbody tr:not(.filtered)', this).each(function(index) {
        if ($(this).is(".noStripe")) { return true; }        
        if ($(this).parents('tbody').is(".filtered")) { return true; }        
        if ($('th',this).length) {
          $(this).addClass('subhead');
          rowIndex = -1;
        } else {
          if (rowIndex % 2 == 0) {
            $(this).removeClass('odd').addClass('even');
          }
          else {
            $(this).removeClass('even').addClass('odd');
          }
        };
        rowIndex++;
      });
    });
    $(this).trigger('stripe');
  });
});

$(document).ready(function() {
  $('table.sortable').each(function() {
    var $table = $(this);    

    $table.find('th').each(function(column) {
      var findSortKey;

      if ($(this).is('.sort-alpha')) {
        findSortKey = function($cell) {
          return $cell.find('.sort-key').text().toUpperCase() +
                                    ' ' + $cell.text().toUpperCase();
        };
      }

      else if ($(this).is('.sort-numeric')) {
        findSortKey = function($cell) {
          var key = parseFloat($cell.text().replace(/[\$,]/g, ''));
          //alert(key);
          return isNaN(key) ? 0 : key;
        };
      }
      else if ($(this).is('.sort-date')) {
        findSortKey = function($cell) {
          return Date.parse($cell.text());
        };
      }

      if (findSortKey) {
        $(this).addClass('clickable').hover(function() {
          $(this).addClass('hover');
        }, function() {
          $(this).removeClass('hover');
        }).click(function() {
          var newDirection = 1;
          if ($(this).is('.sorted-asc')) {
            newDirection = -1;
          }

          rows = $table.find('tbody > tr').get();

          $.each(rows, function(index, row) {          
            row.sortKey =
                        findSortKey($(row).children('td').eq(column));                        
          });
          rows.sort(function(a, b) {
            if (a.sortKey < b.sortKey) return -newDirection;
            if (a.sortKey > b.sortKey) return newDirection;
            return 0;
          });
          $.each(rows, function(index, row) {
            $table.children('tbody').append(row);
            row.sortKey = null;
          });

          $table.find('th').removeClass('sorted-asc')
                                        .removeClass('sorted-desc');
          var $sortHead = $table.find('th').filter(':nth-child('
                                               + (column + 1) + ')');
          if (newDirection == 1) {
            $sortHead.addClass('sorted-asc');
          } else {
            $sortHead.addClass('sorted-desc');
          }
          $table.find('td').removeClass('sorted')
            .filter(':nth-child(' + (column + 1) + ')')
                                                 .addClass('sorted');
          $table.trigger('repaginate');
          $table.trigger('stripe');
        });
      }
    });
  });
});

$(document).ready(function() {
  $('table.paginated').each(function() {
    var currentPage = 0;
    var numPerPage = 25;
    var resultsPerPage = new Array(25, 50, 100);

    var $table = $(this);

    $table.bind('repaginate', function() {      
      var numRows = $table.find('tbody tr').length;
      var numPages = Math.ceil(numRows / numPerPage);
      if (currentPage+1>numPages) { currentPage = numPages-1; }      

      var start=currentPage * numPerPage;
      var end=(currentPage + 1) * numPerPage;
      $table.find('tbody tr').show()
        .slice(0, start)
          .hide()
        .end()
        .slice(end)
          .hide()
        .end();        

      var $pagerContainer = ($("#pagerContainer").html()==null?$('<div class="pagerContainer" id="pagerContainer"></div>'):$("#pagerContainer"));
      var $pager = ($("#pager").html()==null?$('<div id="pager" class="pager"></div>'):$("#pager"));
      var $showing = ($("#showing").html()==null?$('<div id="showing" class="showing"></div>'):$("#showing"));

      $pager.appendTo($pagerContainer);
      $showing.appendTo($pagerContainer);

      if ($("#pages").html()==null) {
        var $pages = $('<span id="pages"></span>')
        $pages.appendTo($pager);
      } else { var $pages = $("#pages"); $pages.empty(); }

      for (var page = 0; page < numPages; page++) {
      $('<span class="page-number'+(page==currentPage?' active':'')+'">' + (page + 1) + '</span>')
       .bind('click', {'newPage': page}, function(event) {
         currentPage = event.data['newPage'];
         $table.trigger('repaginate');
         $(this).addClass('active').siblings().removeClass('active');
       })
       .appendTo($pages).addClass('clickable');
      }
      //$pager.find('span.page-number:first').addClass('active');

      if ($("#rpp").html()==null) {
        var $rpp = $('<span id="rpp"></span>')
        $rpp.appendTo($pager);
      } else { var $rpp = $("#rpp"); }

      if ($("#rpp").html()==null) {
        var $rppSel = $('<select id="select-rpp"></select>')
          .bind('change', function(e) {
            numPerPage = $(this).val();
            $table.trigger('repaginate');
          }).appendTo($rpp);
        for(i=0;i<resultsPerPage.length;i++) {
          $.create('option', {'value': resultsPerPage[i]}, resultsPerPage[i]).appendTo($rppSel);
        }
        $rppSel.appendTo($rpp);
      }

      $showing.html('<span class="showingSpan">Showing <span class="showingPos">'+(start+1)+'</span> - <span class="showingPos">'+(numRows<((start*1)+(numPerPage*1))?numRows:((start*1)+(numPerPage*1)))+'</span> of <span class="showingPos">'+numRows+'</span></span>');

      $pagerContainer.insertBefore($table);
      $table.trigger('stripe');
    });

    $table.trigger('repaginate');    
  });
});
