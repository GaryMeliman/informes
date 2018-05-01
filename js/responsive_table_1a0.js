!function () {
  $(function () {
    return $('.datatable').dataTable({
      aoColumnDefs: [
        {
          bSortable: !1,
          aTargets: [0,5]
        }
      ],
      aaSorting: []
    }),
    $('.datatable').each(function () {
      var a,t,e,p;
  	  var ruta_mg1;      
      return a = $(this),
      e = a.closest('.dataTables_wrapper').find('div[id$=_filter] input'),
      e.attr('placeholder', 'Buscar'),
      e.addClass('form-control input-sm'),

//      p = a.closest('.dataTables_wrapper').find('.clearfix'),
//      p.append( '<center><button  onclick="window.location.href=ruteador(1,ruta_mg1)" type="button" class="btn btn-iconed btn-default btn-sm"><i class="fa fa-save"></i> Nuevo</button></center>' ),

      t = a.closest('.dataTables_wrapper').find('div[id$=_length] select'),
      t.addClass('form-control input-sm'),

      t = a.closest('.dataTables_wrapper').find('div[id$=_info]'),
      t.css('margin-top', '18px')
    })
  })
}.call(this);
;
