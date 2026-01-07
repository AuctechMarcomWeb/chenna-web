<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

   <style type="text/css">
   .ratingpoint{
    color: red;
  }
  i.fa.fa-fw.fa-trash {
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
}
   </style>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
            <!-- /.box-header -->
            
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="box-body">
                <section class="col-lg-12 connectedSortable">
          <div class="box box-solid bg-light-blue-gradient">
              <div class="box-header">
                 <div class="pull-right box-tools">
                 </div>
                 <i class="fa fa-map-marker"></i>
                 <h3 class="box-title">
                 Delivery Boy Location
                 </h3>
              </div>
                <?php 
                   
                      foreach($getData as $val){ ?>
                     <?php 
                      $address_latlng[]=array

                         (
                           'lat'=>$val["latitude"],
                           'lng'=>$val["longitude"]
                         );
                       ?>
                    <?php }  ?>        
                     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxpNXGcquaqlg4PeuA1lqAU-tl4-KQ-xg&callback"></script>
                <script type="text/javascript">
                    var markers = <?php echo json_encode($address_latlng);?>

                    window.onload = function () {
                    var mapOptions = {
                    center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                    var infoWindow = new google.maps.InfoWindow();
                    var lat_lng = new Array();
                    var latlngbounds = new google.maps.LatLngBounds();
                    for (i = 0; i < markers.length; i++) {
                    var data = markers[i]
                    var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                    lat_lng.push(myLatlng);
                    var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: data.title
                    });
                    latlngbounds.extend(marker.position);
                    (function (marker, data) {
                    google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                    });
                    })(marker, data);
                    }
                    map.setCenter(latlngbounds.getCenter());
                    map.fitBounds(latlngbounds);

                    }
                   </script></pre>
                  <div id="dvMap" style="width:100%; height: 500px;color:black;"></div>
          </div>
       
            <br/> 
      </section>
           
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


<script>
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/DeliveryStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Delivery Boy ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Delivery Boy ?");}

   
       
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        console.log(response);
        if(response == 1){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/act.png")?>');} 
        if(response == 2){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/delete.png")?>');}
        //console.log(response);
      }
    });
    }
  }
 

  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })


  
</script>