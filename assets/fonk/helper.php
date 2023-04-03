<?php 
try  {
	$baglanti = new PDO("mysql:host=localhost;dbname=phpsms;charset=utf8", "root","");
	$baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
} 
catch (PDOException $e) {
	die($e->getMessage());
}


class Phpsms {

    public $IM_PUBLIC_KEY,$IM_SECRET_KEY,$IM_SENDER;
	function __construct() {
        try  {
            $baglanti = new PDO("mysql:host=localhost;dbname=phpsms;charset=utf8", "root","");
            $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        } 
        catch (PDOException $e) {
            die($e->getMessage());
        }
        $bilgilericek=$baglanti->prepare("SELECT * FROM ayarlar");
        $bilgilericek->execute();
        $al=$bilgilericek->fetchAll();
        
	
    $this->IM_PUBLIC_KEY= $al[0]["apikey"];
    $this->IM_SECRET_KEY= $al[0]["guvkey"] ; 
    $this->IM_SENDER    = $al[0]["baslik"]; 
	}
	public function bakiyekontrol() {

        
        $xml = '
        <request>
            <authentication>
            <username>5414421093</username>
            <password>TAHAtuna5319*</password>
            </authentication>
        </request>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://api.iletimerkezi.com/v1/get-balance');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);

        preg_match_all('|\<sms\>.*\<\/sms\>|U', $result, $bakiye, PREG_PATTERN_ORDER);
        echo $bakiye[0][0];
        
        /*if(isset($matches[0])&&isset($matches[0][0])) {
            if( $matches[0][0] == '<code>200</code>' ) {//msj hata kodu
                return true;
            }
        }

        return false;*/
    }
    public function send($text,$gsm) {

        $p_hash = hash_hmac('sha256', $this->IM_PUBLIC_KEY, $this->IM_SECRET_KEY);

        $xml = '
        <request>
            <authentication>
                <key>'.$this->IM_PUBLIC_KEY.'</key>
                <hash>'.$p_hash.'</hash>
            </authentication>
            <order>
                <sender>'.$this->IM_SENDER.'</sender>
                <sendDateTime></sendDateTime>
                <message>
                    <text><![CDATA['.$text.']]></text>
                    <receipents>
                        <number>'.$gsm.'</number>
                    </receipents>
                </message>
            </order>
        </request>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://api.iletimerkezi.com/v1/send-sms');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);

        preg_match_all('|\<code\>.*\<\/code\>|U', $result, $matches, PREG_PATTERN_ORDER);
        if(isset($matches[0])&&isset($matches[0][0])) {
            if( $matches[0][0] == '<code>200</code>' ) {//msj hata kodu
                return true;
            }
        }

        return false;
    }

    
}
class genelislemler{
    function numaralarial($baglanti){
        $numara=$baglanti->prepare("SELECT numaralar.*, gruplar .ad AS GrupAd FROM numaralar JOIN gruplar ON numaralar.grupid=gruplar.id");
        $numara->execute();
        while($gelen=$numara->fetch(PDO::FETCH_ASSOC)):
            echo '<div class="row font-weight-bold p-1">
            <div class="col-lg-5 ">'.$gelen["tel"].'</div>
            <div class="col-lg-4">'.$gelen["GrupAd"].'</div>
            <div class="col-lg-1"><a href="index.php?islem=numarasil&id='.$gelen["id"].'" class="text-danger "><i class="ti-close"></i></a> </div>
            <div class="col-lg-2"><a href="index.php?islem=numaraguncelle&id='.$gelen["id"].'" class="text-success"><i class="ti-reload"></i></a> </div>
        </div>';
        endwhile;

    }
    function grupal($baglanti){
        $grup=$baglanti->prepare("SELECT * FROM gruplar");
        $grup->execute();
        while($gelen=$grup->fetch(PDO::FETCH_ASSOC)):
            echo '<div class="row font-weight-bold p-1">
            <div>'.$gelen["ad"].'</div>
        </div>';
        endwhile;
    }
    function sablonal($baglanti){
        $sablon=$baglanti->prepare("SELECT * FROM sablonlar");
        $sablon->execute();
        while($gelen=$sablon->fetch(PDO::FETCH_ASSOC)):
            echo '<div class="row font-weight-bold p-1">
            <div>'.$gelen["ad"].'</div>
        </div>';
        endwhile;
    }
    function tekverial($baglanti,$tabload,$kosul){
        $mevcutal=$baglanti->prepare("SELECT * FROM $tabload WHERE ".$kosul);
		$mevcutal->execute();
		return $mevcutal->fetchAll();
    }
    function grupkontrol($baglanti,$tabload,$grupid){
        $gruplar=$baglanti->prepare("SELECT * FROM $tabload");
		$gruplar->execute();
		while($sonuc=$gruplar->fetch(PDO::FETCH_ASSOC)):
			if($grupid==$sonuc["id"]):
				echo '<option value="'.$sonuc["id"].'" selected>'.$sonuc["ad"].'</option>';
			else:
                echo '<option value="'.$sonuc["id"].'">'.$sonuc["ad"].'</option>';
			endif;						
		endwhile;
        
    }
    function hizliislemler($baglanti,$tabload){
        $a=$baglanti->prepare("SELECT * FROM $tabload");
		$a->execute();
        echo '<select name="'.$tabload.'" class="form-control p-0">
        <option value="0">Seçiniz</option>';
		while($sonuc2=$a->fetch(PDO::FETCH_ASSOC)):
                echo '<option value="'.$sonuc2["id"].'">'.$sonuc2["ad"].'</option>';				
		endwhile;
        echo '</select>';
        
    }
}
if(isset($_GET["islem"]) && $_GET["islem"]=="grupcek"):
    $a=$baglanti->prepare("SELECT * FROM numaralar WHERE grupid=".$_POST['grupid']);
		$a->execute();
		while($sonuc2=$a->fetch(PDO::FETCH_ASSOC)):
                echo $sonuc2["tel"]."\r";				
		endwhile;
endif;



?>