  </div>
  <!------ End content ---------->
</div>
</div>



  <div class="modal fade" id="Modal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"><b>Add Sounding Manual</b></h4>
              </div>
              <div class="modal-body">

                      <div class="row">
                          <div class="column col-md-6">
                              <div><input type="hidden" class="form-control" id="id" name="id" readonly></div>
                              <div>
                                  <label>ATG Name : </label>
                              </div>
                              <div>
                                  <input type="text" class="form-control" id="atg_id" name="atg_id" readonly>
                              </div>
                          </div>
                          <div class="column col-md-6">
                              <div>
                                  <label>QTY Observe</label>
                              </div>
                              <div>
                                  <input type="number" class="form-control" id="qty_observe" name="qty_observe">

                              </div>
                          </div>
                      </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn1 btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                  <button class="btn btn-primary btn-flat" name="edit"><i class="fa fa-save"></i> Save</button>

              </div>
          </div>
      </div>
  </div>
  <div class="modal fade" id="Modal2">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"><b>Add Sounding Manual</b></h4>
              </div>
              <div class="modal-body">

                      <div class="row">
                          <div class="column col-md-6">
                              <div><input type="hidden" class="form-control" id="id2" name="id2" readonly></div>
                              <div>
                                  <label>ATG Name : </label>
                              </div>
                              <div>
                                  <input type="text" class="form-control" id="atg_id2" name="atg_id2" readonly>
                              </div>
                          </div>
                          <div class="column col-md-6">
                              <div>
                                  <label>QTY Observe</label>
                              </div>
                              <div>
                                  <input type="number" class="form-control" id="qty_observe2" name="qty_observe2">

                              </div>
                          </div>
                      </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn1 btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                  <button class="btn2 btn-primary btn-flat" name="edit"><i class="fa fa-save"></i> Save</button>

              </div>
          </div>
      </div>
  </div>
<!-- footer
<div class="footer">
  <p>Footer</p>
</div>
<-->

<script>
  $(function(){
    $('a[href$="Modal2"]').on("click", function (){
      $('#Modal2').modal('show');
      var id = $(this).data('id');
      var name = $(this).data('name');
      $('#atg_id2').val(name);
      $('#id2').val(id);
    });
  });

  $('.btn2').click(function (){
    var id = document.getElementById('id2').value;
    var qty = document.getElementById('qty_observe2').value;

    $.ajax({
      url: '<?php echo base_url() ?>index.php/home/save_manual/',
      type: 'post',
      data: {id:id,qty_observe:qty},
      dataType: 'json',
      success: function(result){

      }
    });
    $('#Modal2').modal('hide');
    reload();
  });
</script>
<script>

    $(function () {
       $('a[href$="#Modal"]').on("click", function () {
          $('#Modal').modal('show');
          var id =$(this).data('id');
          var name = $(this).data('name');
          $('#atg_id').val(name);
          $('#id').val(id);

       });

    });


    $('.btn').click(function () {
        var id = document.getElementById('id').value;
        var qty = document.getElementById('qty_observe').value;

       $.ajax({
            url: '<?php echo base_url() ?>index.php/home/simpan/',
            type: 'post',
            data: {id:id,qty_observe:qty},
            dataType: 'json',
            success: function (data) {

            }
        });
        //alert(qty);
        $('#Modal').modal('hide');
        reload();
    });
function reload(){
    setTimeout(function() {
        location.reload();

    }, 1000);
}
</script>
  <script>
      $('[data-toggle=popover1]').popover({
          content: $('#myInfo').html(),
          html: true
      }).click(function () {
          $(this).popover('show');
      });
  </script>
</body>
</html>
