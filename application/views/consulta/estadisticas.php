</head>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">



      
     
    </section>


    
    <!--Modals-->

    <!-- Main content -->
    <section class="content">
      <!-- solid sales graph -->

      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Egresos de Productos por día</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="artPorDia" style="height: 250px;"></div>
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /.box -->
        </section>


          

          </div>

        <div class="row">
          <section class="col-lg-6 connectedSortable">
         
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Top 10 cantidad Productos egresados por Destino</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div id="bar-example" style="height: 250px;"></div>
              </div>
              <!-- /.box-body -->
              
              <!-- /.box-footer -->
            </div>
            <!-- /.box -->

          </section>

          <section class="col-lg-6 connectedSortable">
         
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Top 10 Productos con mas egresos</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div id="top10egresos" style="height: 250px;"></div>
              </div>
              <!-- /.box-body -->
              
              <!-- /.box-footer -->
            </div>
            <!-- /.box -->

          </section>

        </div>

        <div class="row">
          <section class="col-lg-12 connectedSortable">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Consumo por Presentación</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-8">
                    <canvas id="pieChart" width="1366px" height="400px" style="width:100%;height:400px"></canvas>
                  </div>
                  <div class="col-md-4">
                    <div id="js-legend" class="chart-legend"></div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer no-padding">
              
            </div>
              <!-- /.box-footer -->
            </div>


            <!-- /.box -->
          </section>

        </div>
    
    </section>
    <!-- /.content -->
    

  
</div>
<!-- ./wrapper -->


