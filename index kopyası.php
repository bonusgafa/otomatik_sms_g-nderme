<?php 
require_once("assets/fonk/helper.php");
$sms= new Phpsms;
$genelislem = new genelislemler;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
   
    <title>PHP SMS İŞLEMLERİ-Yönetim Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">    
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">   
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script>
	$(document).ready(function(){
		
		$(".sabloncerceve").hide();
		$(".grupcerceve").hide();
		$(".sablongetir").click(function(){
			$(".sabloncerceve").toggle();
		});
		$(".grupgetir").click(function(){
			$(".grupcerceve").toggle();
		});
		$("select[name='sablonlar']").on('change',function(){
			$("textarea[name='mesaj']").val("");
			$("textarea[name='mesaj']").val($("select[name='sablonlar'] option:selected").text());
			$(".sabloncerceve").hide();
		});
		$("select[name='gruplar']").on('change',function(){
			
			var gelenid=$(this).val();
			$.post("assets/fonk/helper.php?islem=grupcek",{"grupid":gelenid},function(gelen_cevap){
				
				//$("textarea[name='numaralar']").val(""); 
				//$("textarea[name='numaralar']").val(gelen_cevap);//tekli grup seçme
				$("textarea[name='numaralar']").append(gelen_cevap);//çoklu grup seçme
				$(".grupcerceve").hide();
			});
		});
	});
	</script>
	<style>
		.sabloncerceve{
			width: 200px;
			height: 100px;
			background: rgb(0,0,0);
			background: linear-gradient(90deg, rgba(0,0,0,1) 0%, rgba(255,0,0,1) 50%, rgba(0,0,0,1) 100%);
			border-radius: 5px;
			border: 1% solid forestgreen ;
			position: absolute;
			top: 50%;
			left: 50%;
			margin-top: -50px;
			margin-left: -100px;
			z-index: 1;

		}
		.sablongetir:hover{
			cursor: pointer;
		}
		.grupcerceve{
			width: 200px;
			height: 100px;
			background: rgb(0,0,0);
			background: linear-gradient(90deg, rgba(0,0,0,1) 0%, rgba(255,0,0,1) 50%, rgba(0,0,0,1) 100%);
			border-radius: 5px;
			border: 1% solid forestgreen ;
			position: absolute;
			top: 50%;
			left: 50%;
			margin-top: -50px;
			margin-left: -100px;
			z-index: 1;

		}
		.grupgetir:hover{
			cursor: pointer;
		}
		.bakiyeiskelet{
			position: absolute;
			text-align:center;
			right: 25px;
			left: 25px;
			background: red ;
		}
	</style>
	
</head>

<body>
 

    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="index.php"><img src="assets/images/logo/logo.png" alt="logo"></a>
                </div>
            </div>
			
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
							                                                    
                            <li><a href="index.php?islem=smsgonder"><i class="ti-signal"></i> <span>SMS GÖNDER</span></a></li>
                            <li><a href="index.php?islem=numaralar"><i class="ti-tablet"></i> <span>NUMARALAR</span></a></li>
                            <li><a href="index.php?islem=ayarlar"><i class="ti-settings"></i> <span>APİ AYARLARI</span></a></li>  
							<kbd class="bakiyeiskelet text-white alert alert-black md-2"><h6><?php $sms->bakiyekontrol(); ?> <span>SMS HAKKINIZ KALMIŞTIR</h6></span></kbd>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                      
                    </div>
                    <!-- profile info & task notification -->
                 
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->

            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- sales report area start -->
               <div class="row">
                    <div class="col-lg-12 mt-5 bg-white text-center" style="min-height:500px;">
						
			
					
                       <?php
					   
					   switch (@$_GET["islem"]):
					   
					   	case "smsgonder":
						echo '<div class="row">
						<div class="col-lg-6 mt-2 anaiskelet mx-auto">';
						
						if ($_POST) :							
						echo '<div class="row">		 
						<div class="col-lg-12 mt-1">';
						
						$mesaj=htmlspecialchars(strip_tags($_POST["mesaj"]));
						$numaralar=htmlspecialchars(strip_tags($_POST["numaralar"]));

						$dizi=explode(",",$numaralar);
						
						foreach($dizi as $numara):
							if(!$sms->send($mesaj,$numara)):
								echo '<div class="alert alert-danger">Bu numaraya: '.$numara.' Gönderilmedi.</div>';
								
							endif;
						
						endforeach;
						echo '<div class="alert alert-success">SMSLER GÖNDERİLDİ</div>';

						echo '</div>
						</div>';					
							
						else:	
						?>
						<div class="row">
								<div class="col-lg-12 baslik"> <h3>SMS GÖNDER</h3> </div>
												 
								  <div class="col-lg-12 mt-1"> 
									<div class="row">
									<div class="col-lg-6 col-form-label-lg">Sms Başlığı </div>
									<div class="col-lg-6">
									<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
									<input type="text" name="baslik" value="<?php echo $sms->IM_SENDER; ?>" class="form-control" readonly> </div>
									</div>
									</div>
														
									<div class="col-lg-12 mt-1 col-form-label-lg"> Mesaj 
										<span class="sablongetir float-right col-form-label-sm text-primary">Şablon Seç</span>
									</div>
									<div class="sabloncerceve"><span class="text-white">ŞABLONLAR</span>
										<?php $genelislem->hizliislemler($baglanti,"sablonlar"); ?>
									</div>
									<div class="col-lg-12 mt-1 "> <textarea class="form-control" name="mesaj"  rows="5" placeholder="Mesajınızı Yazınız" required></textarea></div>
														
									<div class="col-lg-12 mt-1 col-form-label-lg">Numaralar 
									<span class="grupgetir float-right col-form-label-sm text-primary">Grup Seç</span>
									</div>
									<div class="grupcerceve"><span class="text-white">GRUPLAR</span>
									<?php $genelislem->hizliislemler($baglanti,"gruplar"); ?>
									</div>
									<div class="col-lg-12 mt-1 "> <textarea class="form-control" name="numaralar"  rows="5" placeholder="Numaraları satır satır yazınız" required></textarea></div>
														
														<div class="col-lg-12 mt-1"> 
												  	<input type="submit" name="btn" value="GÖNDER" class="btn btn-success mt-2 mb-2">
													</form>
														</div>
											
											</div>
						
						<?php
						endif;
						?>	 			
						</div></div>
						<?php
						
						break;
						
						case "numaralar":
						echo '<div class="row">
						<div class="col-lg-6 mt-2 anaiskelet mx-auto">';
											
						if ($_POST) :
						echo '<div class="row">		 
						<div class="col-lg-12 mt-1">SONUÇ</div>
						</div>';				
						else:
						?>
						<div class="row">
						<div class="col-lg-12 baslik"> 
								<div class="row">
										<div class="col-lg-9 col-form-label-lg pt-3"><h3>TELEFON NUMARALARI YÖNETİM</h3></div>
										<div class="col-lg-3 p-2">
											<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    İŞLEMLER
  </button>
  <div class="dropdown-menu bg-white">
    <a class="dropdown-item" href="index.php?islem=tekekle">Tek Ekle</a>
    <a class="dropdown-item" href="index.php?islem=topluekle">Toplu Ekle</a>
    <a class="dropdown-item" href="index.php?islem=grupolustur">Grup Oluştur</a>
	<a class="dropdown-item" href="index.php?islem=sablonolustur">Şablon Oluştur</a>
   
  </div>
</div>			
										</div>
											</div>
						</div>
											
								<div class="col-lg-12 mt-1"> 
									<div class="row font-weight-bold p-1 text-danger">
										<div class="col-lg-5 ">Telefon No</div>
										<div class="col-lg-4">Grup </div>
										<div class="col-lg-1">Sil </div>
										<div class="col-lg-2">Güncelle </div>

									</div>
									
									<?php
									$genelislem->numaralarial($baglanti);

									
									?>
									
								</div>
														
												
											
						</div>
						
						<?php	endif;	?>
						
						<div class="col-lg-12 mt-1"> 
									<div class="row font-weight-bold p-1 text-danger">
										<div class="mt-0">Grup Listesi<hr class="p-0"></div>
									</div>
									
									<?php
										$genelislem->grupal($baglanti);
									?>
								</div>
								<div class="col-lg-12 mt-1"> 
									<div class="row font-weight-bold p-1 text-danger">
										<div class="mt-0">Sablon Listesi<hr class="p-0"></div>
									</div>
									
									<?php
										$genelislem->sablonal($baglanti);
									?>
								</div>	
						</div></div>

						<?php
						break;
						case "ayarlar":
							echo'<div class="row">
							<div class="col-lg-6 mt-2 anaiskelet mx-auto">';						
							
							if ($_POST) :
							echo '<div class="row"><div class="col-lg-12 mt-1">';
							
							$apikey=htmlspecialchars(strip_tags($_POST["apikey"]));
							$apisecret=htmlspecialchars(strip_tags($_POST["guvkey"]));
							$apibaslik=htmlspecialchars(strip_tags($_POST["baslik"]));
							$guncelle=$baglanti->prepare("UPDATE ayarlar SET apikey=?,guvkey=?,baslik=?");
							if($guncelle->execute(array($apikey,$apisecret,$apibaslik))):
								echo '<div class="alert alert-info mt-3">GÜNCELLEME BAŞARILI</div>';
								header("Refresh:2;url='index.php?islem=ayarlar'");
							else:
								echo '<div class="alert alert-danger mt-3">GÜNCELLEME YAPILAMADI</div>';
								header("Refresh:2;url='index.php?islem=ayarlar'");
							endif;
							echo '</div></div>';
							else:
								
							?>
							<div class="row">
							<div class="col-lg-12 baslik"> <h3>APİ AYARLARI</h3> </div>
													 
							<div class="col-lg-12 mt-1"> 
							<div class="row">
							<div class="col-lg-6 col-form-label-lg">Api Anahtarı </div>
							<div class="col-lg-6">
							<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
							<input type="text" name="apikey" class="form-control" value="<?php echo $sms->IM_PUBLIC_KEY; ?>"> </div>
	
							</div>
							</div>
															
							<div class="col-lg-12 mt-1"> 
							<div class="row">
							<div class="col-lg-6 col-form-label-lg">Güvenlik Anahtarı </div>
							<div class="col-lg-6"><input type="text" name="guvkey" class="form-control" value="<?php echo $sms->IM_SECRET_KEY; ?>"> </div>
	
							</div>
							</div>
															
							<div class="col-lg-12 mt-1"> 
							<div class="row">
							<div class="col-lg-6 col-form-label-lg">Sms Başlığı</div>
							<div class="col-lg-6"><input type="text" name="baslik" class="form-control" value="<?php echo $sms->IM_SENDER; ?>"> </div>
	
							</div>
							</div>
							<div class="col-lg-12 mt-1"> 
							<input type="submit" name="btn" value="KAYDET" class="btn btn-success btn-block mt-2 mb-2">
							</form>
							</div>					
							</div>
							<?php	
							endif;	
							?>		 			
							</div>
							</div>
							<?php
							break;
						case "numarasil":
						echo'<div class="row">
						<div class="col-lg-6 mt-2 anaiskelet mx-auto">';						
						
						if ($_GET["id"] && is_numeric($_GET["id"])) :
						echo '<div class="row"><div class="col-lg-12 mt-1">';
						
						$sil=$baglanti->prepare("DELETE FROM numaralar WHERE id=".$_GET["id"]);
						if($sil->execute()):
							echo '<div class="alert alert-info mt-3">NUMARA SİLİNDİ</div>';
							header("Refresh:2;url='index.php?islem=numaralar'");
						else:
							echo '<div class="alert alert-danger mt-3">SİLİNİRKEN HATA OLUŞTU</div>';
							header("Refresh:2;url='index.php?islem=numaralar'");
						endif;
						echo '</div></div>';
						else:
							header("Location:index.php?islem=numaralar");
						endif;
						break;
						case "numaraguncelle":
							echo'<div class="row">
							<div class="col-lg-6 mt-2 anaiskelet mx-auto">';						
							
							if ($_POST) :
							echo '<div class="row"><div class="col-lg-12 mt-1">';
							
							$tel=htmlspecialchars(strip_tags($_POST["tel"]));
							$grup=htmlspecialchars(strip_tags($_POST["grup"]));
							$telid=htmlspecialchars(strip_tags($_POST["telid"]));
							$guncelle=$baglanti->prepare("UPDATE numaralar SET tel=?,grupid=? WHERE id=?");
							if($guncelle->execute(array($tel,$grup,$telid))):
								echo '<div class="alert alert-info mt-3">GÜNCELLEME BAŞARILI</div>';
								header("Refresh:2;url='index.php?islem=numaralar'");
							else:
								echo '<div class="alert alert-danger mt-3">GÜNCELLEME YAPILAMADI</div>';
								header("Refresh:2;url='index.php?islem=numaralar'");
							endif;
							echo '</div></div>';
							else:
								$id=$_GET["id"];
								$gelenveri=$genelislem->tekverial($baglanti,"numaralar","id=$id");
							?>
							<div class="row">
							<div class="col-lg-12 baslik"> <h3>Numara Güncelleme</h3> </div>
													 
							<div class="col-lg-12 mt-1"> 
							<div class="row">
							<div class="col-lg-6 col-form-label-lg">Numara</div>
							<div class="col-lg-6">
							<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
							<input type="text" name="tel" class="form-control" value="<?php echo $gelenveri[0]["tel"]; ?>"> </div>
	
							</div>
							</div>
															
							<div class="col-lg-12 mt-1"> 
							<div class="row">
							<div class="col-lg-6 col-form-label-lg">Gruplar</div>
							<div class="col-lg-6">
								<select name="grup" class="form-control p-1">
								<?php
								$genelislem->grupkontrol($baglanti,"gruplar",$gelenveri[0]["grupid"]);
								?>
								</select>

							</div>
	
							</div>
							</div>
							<div class="col-lg-12 mt-1">
								<input type="hidden" name="telid" value="<?php echo $id ?>">
							<input type="submit" name="btn" value="GÜNCELLE" class="btn btn-success btn-block mt-2 mb-2">
							</form>
							</div>					
							</div>
							<?php	
							endif;	
							?>		 			
							</div>
							</div>
							<?php
							break;
							case "tekekle":
								echo'<div class="row">
								<div class="col-lg-6 mt-2 anaiskelet mx-auto">';						
								
								if ($_POST) :
								echo '<div class="row"><div class="col-lg-12 mt-1">';
								
								$tel=htmlspecialchars(strip_tags($_POST["tel"]));
								$grup=htmlspecialchars(strip_tags($_POST["grup"]));
								
								$ekle=$baglanti->prepare("INSERT INTO numaralar (tel,grupid) VALUES(?,?)");
								if($ekle->execute(array($tel,$grup))):
									echo '<div class="alert alert-info mt-3">EKLEME BAŞARILI</div>';
									header("Refresh:2;url='index.php?islem=numaralar'");
								else:
									echo '<div class="alert alert-danger mt-3">EKLEME YAPILAMADI</div>';
									header("Refresh:2;url='index.php?islem=numaralar'");
								endif;
								echo '</div></div>';
								else:
								?>
								<div class="row">
								<div class="col-lg-12 baslik"> <h3>Numara Ekleme</h3> </div>
														 
								<div class="col-lg-12 mt-1"> 
								<div class="row">
								<div class="col-lg-6 col-form-label-lg">Numara</div>
								<div class="col-lg-6">
								<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
								<input type="text" name="tel" class="form-control"> </div>
		
								</div>
								</div>
																
								<div class="col-lg-12 mt-1"> 
								<div class="row">
								<div class="col-lg-6 col-form-label-lg">Gruplar</div>
								<div class="col-lg-6">
									<select name="grup" class="form-control p-1">
									<?php
									$genelislem->grupkontrol($baglanti,"gruplar",0);
									?>
									</select>
	
								</div>
		
								</div>
								</div>
								<div class="col-lg-12 mt-1">
								<input type="submit" name="btn" value="EKLE" class="btn btn-success mt-2 mb-2">
								</form>
								</div>					
								</div>
								<?php	
								endif;	
								?>		 			
								</div>
								</div>
								<?php
								break;
								case "grupolustur":
									echo'<div class="row">
									<div class="col-lg-6 mt-2 anaiskelet mx-auto">';						
									
									if ($_POST) :
									echo '<div class="row"><div class="col-lg-12 mt-1">';
									
									$ad=htmlspecialchars(strip_tags($_POST["grupad"]));
									
									$ekle=$baglanti->prepare("INSERT INTO gruplar (ad) VALUES(?)");
									if($ekle->execute(array($ad))):
										echo '<div class="alert alert-info mt-3">EKLEME BAŞARILI</div>';
										header("Refresh:2;url='index.php?islem=numaralar'");
									else:
										echo '<div class="alert alert-danger mt-3">EKLEME YAPILAMADI</div>';
										header("Refresh:2;url='index.php?islem=numaralar'");
									endif;
									echo '</div></div>';
									else:
									?>
									<div class="row">
									<div class="col-lg-12 baslik"> <h3>Grup Ekleme</h3> </div>
															 
									<div class="col-lg-12 mt-1"> 
									<div class="row">
									<div class="col-lg-6 col-form-label-lg">Grup Adı</div>
									<div class="col-lg-6">
									<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
									<input type="text" name="grupad" class="form-control"> </div>
			
									</div>
									</div>
																	
									<div class="col-lg-12 mt-1">
									<input type="submit" name="btn" value="EKLE" class="btn btn-success mt-2 mb-2">
									</form>
									</div>					
									</div>
									<?php	
									endif;	
									?>		 			
									</div>
									</div>
									<?php
									break;
									case "sablonolustur":
										echo'<div class="row">
										<div class="col-lg-6 mt-2 anaiskelet mx-auto">';						
										
										if ($_POST) :
										echo '<div class="row"><div class="col-lg-12 mt-1">';
										
										$ad=htmlspecialchars(strip_tags($_POST["sablonicerik"]));
										
										$ekle=$baglanti->prepare("INSERT INTO sablonlar (ad) VALUES(?)");
										if($ekle->execute(array($ad))):
											echo '<div class="alert alert-info mt-3">EKLEME BAŞARILI</div>';
											header("Refresh:2;url='index.php?islem=numaralar'");
										else:
											echo '<div class="alert alert-danger mt-3">EKLEME YAPILAMADI</div>';
											header("Refresh:2;url='index.php?islem=numaralar'");
										endif;
										echo '</div></div>';
										else:
										?>
										<div class="row">
										<div class="col-lg-12 baslik"> <h3>Şablon Ekleme</h3> </div>
																 
										<div class="col-lg-12 mt-1"> 
										<div class="row">
										<div class="col-lg-6 col-form-label-lg">Şablon İçerik</div>
										<div class="col-lg-6">
										<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
										<input type="text" name="sablonicerik" class="form-control"> </div>
				
										</div>
										</div>
																		
										<div class="col-lg-12 mt-1">
										<input type="submit" name="btn" value="EKLE" class="btn btn-success mt-2 mb-2">
										</form>
										</div>					
										</div>
										<?php	
										endif;	
										?>		 			
										</div>
										</div>
										<?php
										break;
										case "topluekle":
											echo'<div class="row">
											<div class="col-lg-6 mt-2 anaiskelet mx-auto">';						
											
											if ($_POST) :
											echo '<div class="row"><div class="col-lg-12 mt-1">';

											$dosya=fopen($_FILES["dosya"]["tmp_name"],"r");
											while(!feof($dosya)):
												@$verilerim.="(".trim(fgets($dosya))."),";
											endwhile;
											fclose($dosya);
											$sonhal=rtrim($verilerim,",");

											$ekle=$baglanti->prepare("INSERT INTO numaralar (tel) VALUES $sonhal");

											if($ekle->execute()):
												echo '<div class="alert alert-info mt-3">TOPLU EKLEME BAŞARILI</div>';
												header("Refresh:2;url='index.php?islem=numaralar'");
											else:
												echo '<div class="alert alert-danger mt-3">TOPLU EKLEME YAPILAMADI</div>';
												header("Refresh:2;url='index.php?islem=numaralar'");
											endif;
											
											echo '</div></div>';
											else:
												
											?>
											<div class="row">
											<div class="col-lg-12 baslik"> <h3>Toplu Telefon Ekleme</h3> </div>
																	 
											<div class="col-lg-12 mt-1"> 
											<div class="row">
											<div class="col-lg-6 col-form-label-lg">Dosya</div>
											<div class="col-lg-6">
											<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
											<input type="file" name="dosya" class="form-control"></div>
					
											</div>
											</div>
																			
											<div class="col-lg-12 mt-1">
											<input type="submit" name="btn" value="YÜKLE" class="btn btn-success mt-2 mb-2">
											</form>
											</div>					
											</div>
											<?php	
											endif;	
											?>		 			
											</div>
											</div>
											<?php
											break;
						
						
						default:
						echo "<h2>SOL MENÜDEN İŞLEM SEÇİNİZ</h2>";
					   endswitch;
					   ?>
                </div>
            </div>
            </div>
        </div>
        <!-- main content area end -->
    </div>
    <!-- page container area end -->

    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>  

    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
