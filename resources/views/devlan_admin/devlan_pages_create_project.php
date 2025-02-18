<?php
session_start();
include('assets/configs/config.php');
include('assets/configs/checklogin.php');
check_login();
$aid=$_SESSION['admin_id'];
  //Create Project
       
            if(isset($_POST['create_Project']))
            {
                $project_name=$_POST['project_name'];
                $project_desc=$_POST['project_desc'];
                $project_category=$_POST['project_category'];
                $user_id=$_SESSION['user_id'];
                $user_email=$_POST['user_email'];
                $date_created=($_POST['date_created']);
                $project_link=$_POST['project_link'];
                $project_files=$_FILES["project_files"]["name"];
                move_uploaded_file($_FILES["project_files"]["tmp_name"],"assets/projects/".$_FILES["project_files"]["name"]);
                      
                $project_avatar=$_FILES["project_avatar"]["name"];
                move_uploaded_file($_FILES["project_avatar"]["tmp_name"],"assets/projects/".$_FILES["project_avatar"]["name"]);
                      
               //sql to inset the values to the database
                $query="insert into projects (project_name, project_desc, project_category, user_id, user_email, date_created,  project_files, project_avatar, project_link) values(?,?,?,?,?,?,?,?,?)";
                $stmt = $mysqli->prepare($query);
                //bind the submitted values with the matching columns in the database.
                $rc=$stmt->bind_param('sssssssss', $project_name, $project_desc, $project_category, $user_id, $user_email, $date_created,  $project_files, $project_avatar, $project_link);
                $stmt->execute();

                
                $msg = "Project Uploaded!";
                  
                
            }

            
?>

<!DOCTYPE html>
<html lang="en">
  
<?php include('assets/_partials/head.php');?>
  <body>
  <div class="be-wrapper be-fixed-sidebar">
    <div class="be-wrapper">
     <!--Head Bar-->
     <?php include("assets/_partials/navbar.php");?>
      <!--side navbar-->
      <?php include("assets/_partials/sidebar.php");?>
      <div class="be-content">
        <?php if(isset($msg))
        {?>
            <script>
                setTimeout(function () 
                { 
                    swal("Success!","<?php echo $msg;?>!","success");
                },
                    100);
            </script>
            <!--Trigger a pretty success alert-->
        <?php }?>
       
        <div class="main-content container-fluid">
          <div class="row wizard-row">
            <div class="col-md-12 fuelux">
                <nav aria-label="breadcrumb" role="navigation">
                  <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="devlan_pages_dashboard.php">Dashbaord</a></li>
                    <li class="breadcrumb-item"><a href="#">Create Project</a></li>
                  </ol>
                </nav>            
              <div class="block-wizard">
                <div class="wizard wizard-ux" id="wizard1">
                   
                  <div class="step-content">
                    <div class="step-pane active" data-step="1">
                      <div class="container p-0">
                      <?php
                $aid=$_SESSION['admin_id'];
                $ret="select * from admin where admin_id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('i',$aid);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
                {
                ?>
                        <form method="POST"  enctype="multipart/form-data" >
                                <!-- General information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Project name *</label>
                                            <input class="form-control" name="project_name" required  type="text" placeholder="Name Your Project">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Project Category</label>
                                            <select id="project_category" name="project_category" class="form-control">
                                                <option selected>Project Categories</option>
                                               <!-- <option>GNS 3 Topologies</option>-->
                                                <option>Packet Tracer Topologies</option>
                                                <option>Network Automation</option>
                                                <option>FrontEnd WebApp</option>
                                                <option>BackEnd WebApp</option>
                                                <option>FullStack WebApp</option>
                                                <option>Android App</option>
                                                <option>Framework WebApp</option>
                                                <option>Non Framework WebApp</option>
                                                <option>Progressive WebApp</option>
                                                <option>Misc Networking Projects</option>
                                                <option>Misc Coding Projects</option>
                                                <option>PDF Cheat Sheets</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="form-control-label">Project Description *</label>
                                                <textarea class="form-control" id="editor" name="project_desc" placeholder="Tell us a few words about your project" rows="3"></textarea>
                                                <small class="form-text text-muted mt-2">You can @mention other users and organizations to link to them to your project</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Your Email *</label>
                                            <input class="form-control" name="user_email" required readonly type="email" value="<?php echo $row->email;?>" placeholder="name@exmaple.com">
                                        </div>
                                    </div>
                                </div>
                                
                                <hr />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Date Project Created *</label>
                                            <input class="form-control" name="date_created" type="date"  placeholder="Select Current Date">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Creator</label>
                                            <input class="form-control"  type="text" value="Devlan Administrator " placeholder="Enter Your Username">
                                        </div>
                                    </div>

                                          <hr/>                      
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Project Files *</label>
                                            <input class=" btn btn-outline-primary" required="required" name="project_files" type="file"  placeholder="Upload Less than 1.5mb Files">
                                            <small class="form-text text-muted mt-2">Please Upload A Zipped/ Compressed Files Less than 1.5mb if huge file use google drive and just share the link. </small>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Project Screenshot *</label>
                                            <input class=" btn btn-outline-primary"  name="project_avatar" type="file"  >
                                            <small class="form-text text-muted mt-2">Drop a screenshot of your Project</small>

                                        </div>
                                    </div>
                                    
                                    <hr/>
                                    <hr>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Provide A Project Link Incase You Have Uploaded It To Github.</label>
                                            <input class="form-control" name="project_link" type="text"  placeholder="https://github.com/MartMbithi/DevLan">
                                        </div>
                                    </div>
                                </div>
                                    
                                </div>                               
                                <hr />
                                <!-- Save changes buttons -->
                                <button type="submit" name="create_Project" class="btn btn-sm btn-outline-success">Share Project</button>
                                <button type="button" class="btn btn-link text-muted">Cancel</button>
                            </form>
                <?php }?>
                      </div>
                    </div>

                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
                <div class="splash-footer"><span><?php echo date ('Y');?> Devlan Labs. Proudly Powered By  <a href="https://martmbithi.github.io/">MartDevelopers</a></span></div>
  
    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="assets/js/app.js" type="text/javascript"></script>
    <script src="assets/lib/fuelux/js/wizard.js" type="text/javascript"></script>
    <script src="assets/lib/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="assets/lib/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap-slider/bootstrap-slider.min.js" type="text/javascript"></script>
    <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
    <script type="text/javascript">
      CKEDITOR.replace('editor')
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//-initialize the javascript
      	App.init();
      	App.wizard();
      });
    </script>
  </body>

</html>