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
  * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
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
              <form method="post" action="<?php echo base_url();?>admin/Dashboard/DeliveryBoyLocation/<?php echo $this->uri->segment(4);?>">
              <div class="container">
              <div class="row">
                <div class="col-md-8">
                  
                <select class="form-control" name="date">
                    <?php 
                     $id =$this->uri->segment(4);
                     $getBoyAddDate = $this->db->get_where('deliver_boy_master',array('id'=>$id))->row_array();
                       $today  = date("d-m-Y"); 
                        $boyAddDate = $getBoyAddDate['add_date']; 
                        $t1   = $boyAddDate;
                        $t2=Date('d-m-Y', strtotime("+1 day"));
                        $begin = new DateTime($t1);
                        $end = new DateTime($t2);
                        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                        foreach ($daterange as $key => $date) { 
                            $alldate = $date->format("d-m-Y");?>
                            <?php 
                            if(empty($_POST['date'])){ ?>
                             <option value="<?php echo $alldate; ?>"<?php echo ($today==$alldate ? 'Selected': '')?>
                              
                              ><?php echo $alldate;?></option>  
                         <?php  } else {?>
                            <option value="<?php echo $alldate; ?>"
                            <?php echo ($_POST['date']==$alldate ? 'Selected': '')?>
                            ><?php echo $alldate;?></option>
                          
                          

                       <?php }} ?>
                   </select>
                  </div>
                <div class="col-md-4"><input type="submit" class="btn btn-primary"></div>
                </div>
           </form>
              </div></br>
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
   $text_json = "";
   foreach($getData as $val)
   {
         $text_json .= '{"lat":'."'".$val["latitude"]."'".', "lng":'."'".$val["longitude"]."'".' },';
   }
  ?>
                                  
					
      <!-- <script src="https://www.google.com/jsapi"></script> -->
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxpNXGcquaqlg4PeuA1lqAU-tl4-KQ-xg">
      </script>
     <!--  <div id="map" style="height:500px;"></div> -->
      <div id="dvMap" style="height: 500px"></div>
      <script type="text/javascript">
    var markers = [<?php echo $text_json; ?>];
   // console.log(markers);
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
 
        //***********ROUTING****************//
 
        //Initialize the Path Array
        var path = new google.maps.MVCArray();
 
        //Initialize the Direction Service
        var service = new google.maps.DirectionsService();
 
        //Set the Path Stroke Color
        var poly = new google.maps.Polyline({ map: map, strokeColor: '#4986E7' });
 
        //Loop and Draw Path Route between the Points on MAP
        for (var i = 0; i < lat_lng.length; i++) {
            if ((i + 1) < lat_lng.length) {
                var src = lat_lng[i];
                var des = lat_lng[i + 1];
                path.push(src);
                poly.setPath(path);
                service.route({
                    origin: src,
                    destination: des,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                }, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                            path.push(result.routes[0].overview_path[i]);
                        }
                    }
                });
            }
        }
    }
</script>
      
    
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