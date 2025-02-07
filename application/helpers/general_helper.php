<?php 
	

	function getMenu($parent = 0, $tipe = "cms")
	{
		$CI = &get_instance();
		$role_id = $CI->session->userdata('userData')['role_id'];
		return $CI->db->join('users_access', 'users_access.menu_id = menus.id_menu')->order_by('sort', 'ASC')->get_where('menus', ['menu_parent' => $parent, 'role_id' => $role_id,'type' => $tipe, 'menus.deleted_at' => null])->result_array();
		// return $CI->db->join('users_access', 'users_access.menu_id = menus.id_menu', 'left')->order_by('sort', 'ASC')->get_where('menus', ['menu_parent' => $parent,'type' => $tipe, 'menus.deleted_at' => null])->result_array();
	}

	
	function convertToIndoNumber($number)
	{
		if (substr($number, 0, 1) === "0") { // cek apakah karakter pertama adalah 0
		    $number = substr_replace($number, "62", 0, 1); // ganti karakter pertama dengan "62"
		} else {
		    $number = $number; // jika karakter pertama bukan 0, tidak perlu mengubah angka
		}
		return $number; // output: 6234567890
	}

	function buatKode($nomor_terakhir, $kunci, $jumlah_karakter = 0)
    {
        /*mencari nomor baru dengan nomor terakhir dan menambahkan
        1 string nomor baru dibawah uni harus dengan format XXX000000
        untuk penggunaan dalam format lain harus disesuaikan sendiri */
        $nomor_baru = intval(substr($nomor_terakhir, strlen($kunci))) + 1;
        //menambahkan nol didepan nomor baru sesuai panjang jumlah karakter
        $nomor_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
        //menyusun kunci dan nomor baru
        $kode = $kunci . $nomor_baru_plus_nol;
        return $kode;
    }

    function getImage(string $url)
    {
        $path = base_url($url);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

	function getErrorValidation()
	{
		$CI = &get_instance();

		$forms = $CI->input->post();
		// var_dump($forms);die;
		$response = [];
		foreach ($forms as $key => $value) {
			if ($key != 'id') {
				$response[$key] = form_error($key);
			}
		}
		return $response;
	}

	function softDelete($table, $where)
	{
		$CI = &get_instance();
		$fields = $CI->db->list_fields($table);
		$by = false;
		foreach ($fields as $key => $value) {
			if ($value == 'deleted_by') {
				$by = true;
			}
		}
		$data = ['deleted_at' => date('Y-m-d H:i:s')];
		if ($by) {
			$data['deleted_by'] = $CI->session->userdata('userData')['id_user'];
		}
		return $CI->db->update($table, $data, $where);

	}

	function encrypt_decrypt($action, $string) {
		    $output = false;
		    $encrypt_method = "AES-256-CBC";
		    $secret_key = '888living';
		    $secret_iv = 'nymgo';
		    // hash
		    $key = hash('sha256', $secret_key);

		    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		    $iv = substr(hash('sha256', $secret_iv), 0, 16);
		    if ($action == 'encrypt'){
		        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		        $output = base64_encode($output);
		    } else if($action == 'decrypt') {
		        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		    }
		    return $output;
		}

	function get_query_string($remove = '')
	{
	    $query_string = $_GET;
	    if ($remove) {
	        if (is_array($remove)) {
	            foreach ($remove as $key => $value) {
	                unset($query_string[$value]);
	            }
	        } else {
	            unset($query_string[$remove]);
	        }
	    }
	    if ($query_string) {
	        return '?'.http_build_query($query_string);
	    }
	    return '';
	}

	function dateIndonesia($date){
        if($date != '0000-00-00'){
            $date = explode('-', $date);
  
            $data = $date[2] . ' ' . bulan($date[1]) . ' '. $date[0];
        }else{
            $data = 'Format tanggal salah';
        }
  
        return $data;
    }
  
    function bulan($bln) {
        $bulan = $bln;
  
        switch ($bulan) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
        }
        return $bulan;
    }

    function hari($hari){
 
	switch($hari){
		case 'Sun':
			$hari = "Minggu";
		break;
 
		case 'Mon':			
			$hari = "Senin";
		break;
 
		case 'Tue':
			$hari = "Selasa";
		break;
 
		case 'Wed':
			$hari = "Rabu";
		break;
 
		case 'Thu':
			$hari = "Kamis";
		break;
 
		case 'Fri':
			$hari = "Jumat";
		break;
 
		case 'Sat':
			$hari = "Sabtu";
		break;
		
		default:
			$hari = "Tidak di ketahui";		
		break;
	}
 
	return $hari;
 
}


function breadcrumb($title, $is_bread = true)
{
	$breadcrumb = '
	<section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>'.$title.'</h2>
          <ol>
            <li><a href="'.base_url().'">Home</a></li>
            <li>'.$title.'</li>
          </ol>
        </div>

      </div>
    </section>
	';
	if ($is_bread == FALSE) {
		$breadcrumb = '';
	}
	return $breadcrumb;
}

function loadView($template, $view, $data)
{
	$CI = &get_instance();
	$data['web'] = $CI->db->get('setting')->row();
	$CI->template->load($template, $view,$data, FALSE);
}

	function uploadFTP($linkLocal,$linkRemote,$filename)
	{
		$CI = &get_instance();
		
		$linkLocal = $linkLocal.$filename;
		$linkRemote = $linkRemote.$filename;
		$config = configFTP();
		$CI->ftp->connect($config);
		// var_dump($linkLocal,$linkRemote);die;
		// $CI->ftp->mirror($linkLocal, $linkRemote);
		$CI->ftp->upload($linkLocal, $linkRemote, 'ascii', 0775);
		$CI->ftp->close();
	}

	function uploadFTPPBN($linkLocal,$linkRemote,$filename, $host, $user, $pass)
	{
		$CI = &get_instance();
			
		$urlRemote = $linkRemote;
		$linkLocal = $linkLocal.$filename;
		$linkRemote = $linkRemote.$filename;

		$CI->load->library('ftp');

		$config['hostname'] = $host;
		$config['username'] = $user;
		$config['password'] = $pass;
		$config['debug']    = TRUE;
		$CI->ftp->connect($config);
		// var_dump($linkRemote);
		// var_dump($linkLocal);die;
		// $CI->ftp->mirror($linkLocal, $urlRemote);
		$list = $CI->ftp->list_files($urlRemote);
		if ($list == FALSE) {
			$CI->ftp->mkdir($urlRemote, 0755);
		}
		$upload = $CI->ftp->upload($linkLocal, $linkRemote, 'ASCII', 0775);
		$CI->ftp->close();
	}

	function deleteFTP($url,$filename, $host, $user, $pass)
	{
		$CI = &get_instance();

		$config = $CI->configFTPPBN($host, $user, $pass);
		$CI->ftp->connect($config);
		$list = $CI->ftp->list_files($url.$filename);
		if ($list) {
			$CI->ftp->delete_file($url.$filename);
		}
		$CI->ftp->close();
	}

	function configFTP()
	{
		$CI = &get_instance();

		$CI->load->library('ftp');

		$config['hostname'] = 'ftp.kssholding.digital';
		$config['username'] = 'u923262879.888living';
		$config['password'] = 'Nymgo888living';
		$config['debug']    = TRUE;
		
		return $config;	
	}


	function configFTPPBN($host,$user, $pass)
	{
		$CI = &get_instance();

		$CI->load->library('ftp');

		$config['hostname'] = $host;
		$config['username'] = $user;
		$config['password'] = $pass;
		$config['debug']    = TRUE;
		
		return $config;	
	}

	function linkFrontEnd()
	{
		return "http://888living.kssholding.digital/";
	}

	function resizeImage($filename, $path, $thumbnail)
    {
		$CI = &get_instance();
		// var_dump($thumbnail);die;
    	$source_path = $path . $filename;
    	$target_path = $thumbnail;

    	if (!is_dir($target_path)) {
		    mkdir($target_path, 0777, TRUE);
		}

    	$config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => TRUE,
          // 'thumb_marker' => '_thumb',
          'width' => 500,
    	);
   
		$CI->load->library('image_lib', $config_manip);
		if (!$CI->image_lib->resize()) {
          echo $CI->image_lib->display_errors();
      	}
    	$CI->image_lib->clear();
    }


    function covertToWebp($url = null, $file = null)
    {
    	$slug = explode(".", $file);
    	$slug = $slug[0];
    	// var_dump($url.$file);die;
    	$image = imagecreatefromstring(file_get_contents($url.$file));
		ob_start();
		imagejpeg($image,NULL,100);
		$cont = ob_get_contents();
		ob_end_clean();
		imagedestroy($image);
		$content = imagecreatefromstring($cont);
		$output = $url.$slug.'.webp';
		imagewebp($content,$output);
		unlink($url.$file);
		imagedestroy($content);
		return $slug.'.webp';
    }

    function __sendEmail($to, $subject, $msg)
	{
		$ci = get_instance(); //buat manggil ci

		$config = array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.googlemail.com',
		  'smtp_port' => 465,
		  'smtp_user' => 'luthfi.ihdalhusnayain98@gmail.com',
		  'smtp_pass' => 'buwztmctrsvdbjzq',
		  'mailtype' => 'html',
		  'charset' => 'utf-8',
		  'newline' => "\r\n"
		);
		$ci->load->library('email', $config);
		$ci->email->initialize($config);

		$ci->email->from('luthfi.ihdalhusnayain98@gmail.com', 'Administrator System');
		$ci->email->to($to);
		$ci->email->subject($subject);
		$ci->email->message($msg);

		if ($ci->email->send()) {
			return ['status' => true];
	    } else {
			return ['status' => false, 'msg' => $ci->email->print_debugger()];
	    }
	}


	function __sendWa($to, $msg)
	{

		// var_dump($to, $msg);die;
		$api_key   = encrypt_decrypt('decrypt', 'UktHL0VmT3U1VVVuaFBaQ0ZLOWljOW0xbERnVTZPeEh0QkI3WjA1L1JibHlKOEtFTS8zKzFHZ1V0UW5lNDBNVA=='); // API KEY Anda
		$id_device = encrypt_decrypt('decrypt', 'ZG1OYTFhdktOdGtwZklaMFBmck1Edz09'); // ID DEVICE yang di SCAN (Sebagai pengirim)
		$url   = 'https://api.watsap.id/send-message'; // URL API
		$no_hp = formatNumber($to); // No.HP yang dikirim (No.HP Penerima)
		$pesan = $msg; // Pesan yang dikirim

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_POST, 1);

		$data_post = [
		   'id_device' => $id_device,
		   'api-key' => $api_key,
		   'no_hp'   => $no_hp,
		   'pesan'   => $pesan
		];
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response, true);
		// $data = [
		//      'api_key' => encrypt_decrypt('decrypt', 'bG9jUkt1M3MvUTBoaGZ1YTlNRm1heTlVcU15ZzFXYkptREwwTXdVR0c2Zz0='),
		//      'sender' => encrypt_decrypt('decrypt', 'bTIyQ0hWUEF2eGpFTDNKWE1HN3FBZz09'),
		//      'number' => formatNumber($to),
		//      'message' => $msg
	    //    ];
	    // $curl = curl_init();
	                                             
	    //   curl_setopt_array($curl, array(
	    //    CURLOPT_URL => 'https://wa.srv3.waboxs.com/send-message',
	    //    CURLOPT_RETURNTRANSFER => true,
	    //    CURLOPT_ENCODING => '',
	    //    CURLOPT_MAXREDIRS => 10,
	    //    CURLOPT_TIMEOUT => 0,
	    //    CURLOPT_FOLLOWLOCATION => true,
	    //    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    //    CURLOPT_CUSTOMREQUEST => 'POST',
	    //    CURLOPT_POSTFIELDS => json_encode($data),
	    //    CURLOPT_HTTPHEADER => array(
	    //    'Content-Type: application/json'
	    //    ),
	    //    ));
	                                             
	    //    $response = curl_exec($curl);                       
	    //    curl_close($curl);
	    //    return json_decode($response, true);
	}

	function formatNumber($number)
	{
		if (substr($number, 0, 2) != '62') {
			$number = "62" . substr($number, 1);
		}

		return $number;
	}
 ?>