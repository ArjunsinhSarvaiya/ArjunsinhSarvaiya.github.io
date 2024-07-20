				</div>
				<!-- footer content -->
				<footer style="margin-top:-23px;">
				    <div class="pull-right">
				        Copyright © <?php echo date('Y'); ?> <?php echo strtoupper(PROJECT_TITLE); ?>
				    </div>
				    <div class="clearfix"></div>
				</footer>
				<!-- /footer content -->
		</div>
	</div>
    <!-- Bootstrap -->
    <script src="<?php echo LINK_URL;?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo LINK_URL;?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo LINK_URL;?>vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo LINK_URL;?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo LINK_URL;?>vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo LINK_URL;?>vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php echo LINK_URL;?>vendors/Flot/jquery.flot.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php echo LINK_URL;?>vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php echo LINK_URL;?>vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo LINK_URL;?>vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo LINK_URL;?>vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo LINK_URL;?>vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    
    <!-- Datatables -->
    <script src="<?php echo LINK_URL;?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo LINK_URL;?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <!-- Switchery -->
    <script src="<?php echo LINK_URL;?>vendors/switchery/dist/switchery.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo LINK_URL;?>build/js/custom.min.js"></script>
    

    <?php /*<script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
                apiKey: "AIzaSyBUdqrd_J-QWjLSwBd5ph0wfU2lTyMBi1M",
                authDomain: "jvca-coaching.firebaseapp.com",
                databaseURL: "https://jvca-coaching.firebaseio.com",
                projectId: "jvca-coaching",
                storageBucket: "jvca-coaching.appspot.com",
                messagingSenderId: "301688459644",
                appId: "1:301688459644:web:8627fd03f6dd0cb90294f9"
            };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();
        messaging.requestPermission()
                .then(function () {
                    console.log("Notification permission granted.");

                    // get the token in the form of promise
                    return messaging.getToken()
                })
                .then(function(token) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?php echo AJAX_URL;?>",
                        data: {DeviceToken:token},
                        success: function(data) {                            
                            if(data.success){
                                console.log(data.message);
                            }else{
                                console.log(data.message);
                            }
                        }
                    });
                    console.log("token is : " + token);
                })
                .catch(function (err) {
                    console.log("Unable to get permission to notify.", err);
                });
                
            messaging.onMessage(notification => {
                            console.log(notification);
                            alert('Notification received!', notification);
                        });

                        messaging.setBackgroundMessageHandler(function(payload) {
                          console.log('Received background message ', payload);
                          // Customize notification here
                          const notificationTitle = 'Background Message Title';
                          const notificationOptions = {
                            body: 'Background Message body.',
                            icon: '/firebase-logo.png'
                          };

                          return self.registration.showNotification(notificationTitle,
                              notificationOptions);
                        });
    </script>*/ ?>
	
  </body>
</html>