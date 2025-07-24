
	<section class="content">
      <div class="container-fluid">

        <!-- Timelime example  -->
        <div class="row">
          	


          <div class="col-12" style="width:100%">
            <!-- The time line -->
            <div class="timeline">

              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-pink" style="width:70%"><?= $proses->rq_nama?></span>
              </div>
              <!-- /.timeline-label -->
              
              <!-- timeline item -->

                
              <?php if($proses->rq_status == 0 && $proses->pgj_status == 3 ){ ?>
                <div>
                <i class="fas fa-file-export bg-yellow"></i>
                  <div class="timeline-item">
                  <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
                    <h3 class="timeline-header"><a href="#">Pengajuan Gudang</a></h3>
                    <div class="timeline-body">
                      <?= date('d-m-Y', strtotime($proses->pgj_tgl))?>
                    </div>
                  </div>

                </div>
            <?php }else if($proses->rq_status == 0 && $proses->pgj_status == 2 ){ ?>
                <div>
                <i class="fas fa-file-export bg-blue"></i>
                <div class="timeline-item">
                  <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
                  <h3 class="timeline-header"><a href="#">Barang Telah Dibeli </a></h3>
                  <div class="timeline-body">
                    <?= date('d-m-Y', strtotime($proses->prc_tgl))?>
                  </div>
                </div>

              </div>
              <div>
                <i class="fas fa-file-export bg-yellow"></i>
                  <div class="timeline-item">
                  <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
                    <h3 class="timeline-header"><a href="#">Pengajuan Gudang</a></h3>
                    <div class="timeline-body">
                      <?= date('d-m-Y', strtotime($proses->pgj_tgl))?>
                    </div>
                  </div>

                </div>
            <?php }else if($proses->rq_status == 1 ){ ?>
                <div>
                <i class="fas fa-file-export bg-green"></i>
                <div class="timeline-item">
                  <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
                  <h3 class="timeline-header"><a href="#">Selesai </a></h3>
                  
                </div>

              </div>
                <div>
                <i class="fas fa-file-export bg-blue"></i>
                <div class="timeline-item">
                  <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
                  <h3 class="timeline-header"><a href="#">Barang Telah Dibeli </a></h3>
                  <div class="timeline-body">
                    <?= date('d-m-Y', strtotime($proses->prc_tgl))?>
                  </div>
                </div>

              </div>
              <div>
                <i class="fas fa-file-export bg-yellow"></i>
                  <div class="timeline-item">
                  <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
                    <h3 class="timeline-header"><a href="#">Pengajuan Gudang</a></h3>
                    <div class="timeline-body">
                      <?= date('d-m-Y', strtotime($proses->pgj_tgl))?>
                    </div>
                  </div>

                </div>

            <?php } ?>
             
            <div>
                  <i class="fas fa-file-export bg-blue"></i>
                  <div class="timeline-item">
                  <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
                    <h3 class="timeline-header"><a href="#">Pengajuan oleh Mandor</a></h3>
                    <div class="timeline-body">
                      <?= date('d-m-Y', strtotime($proses->rq_tgl))?>
                    </div>
                  </div>

                </div>

                


             
              



            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
