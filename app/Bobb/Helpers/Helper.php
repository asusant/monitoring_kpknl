<?php
namespace App\Bobb\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Helper
{
	public function infoPaging($obj)
	{
		return "<div class='row paging-row'>
		<div class='col-xs-12 col-md-8'>
			".$obj->render()."
		</div>
		<div class='col-xs-12 col-md-4 text-right paging-info'>
			<em>".$obj->firstItem()." s.d ".$obj->lastItem()." dari total ".$obj->total()." data</em>
		</div>
		</div>";
	}

	public function arrToList($arr,$type="ul")
	{
		return "<".$type."><li>".implode("</li><li>",$arr)."</li><".$type.">";
	}

	public function genRadio($arr)
	{
		foreach($arr as $a)
		{
			$dt[] = '<label class="radio-inline">
			  '.\Form::radio($a[0],$a[1],$a[2]).' '.$a[3].'
			</label>';
		}
		return implode('',$dt);
	}

	public function buttonDropdown($btns,$title,$class='default')
	{
		$txt = '<div class="btn-group">
			<button type="button" class="btn btn-'.$class.' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				'.$title.' <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">';
		foreach($btns as $btn)
		{
			if($btn == "")
				$txt .= '<li role="separator" class="divider"></li>';
			else
				$txt .=	'<li>'.$btn.'</li>';
		}
		$txt .= '</ul>
		</div>';
		return $txt;
	}

	public function noDataRow($colspan)
	{
		return "<tr><td colspan='$colspan' align='center'><i>Data tidak tersedia.</i></td></tr>";
	}

	public function appendURL($added="")
	{
		if($added == "")
			return "";
		return base64_encode(json_encode($added));
	}

	public function fetchURL($url='')
	{
		if($url == '')
			return array();
		return json_decode(base64_decode($url),true);
	}

	public function link_to_route($route,$title,$params=[],$attributes='')
	{
		return "<a href='".route($route,$params)."' ".$attributes.">$title</a>";
	}

	public function link_to_url($url,$title,$attributes='')
	{
		return "<a href='".$url."' ".$attributes.">$title</a>";
	}

	public function action_to_route($route,$title,$params=[],$attributes='',$js_function='hapus_data')
	{
		return "<a href='javascript:void(0)' onclick='".$js_function."(\"".route($route,$params)."\")' ".$attributes.">$title</a>";
	}

	public function alert($text,$type,$fade=false,$cls_add="")
	{
		$icon = array(
			'warning' => 'fa-warning',
			'info' => 'fa-info',
			'danger' => 'fa-ban',
			'success' => 'fa-check',
		);
		$title = array(
			'warning' => 'Perhatian!',
			'info' => 'Informasi',
			'danger' => 'Error!',
			'success' => 'Berhasil!',
		);
		$cls = 'alert_'.time();
		echo '<div class="alert alert-'.$type.' '.$cls.' alert-dismissible">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4><i class="icon fa '.$icon[$type].'"></i> '.$title[$type].'</h4>
		  <span class="'.$cls_add.'">'.$text.'</span>
		</div>';
		if($fade)
		{
			self::execJS('$(".'.$cls.'").delay(2000).slideUp()');
		}
	}

	public function formatNumber($number,$dec=0,$sep='.')
	{
		if( ! is_numeric($number)) return 0;
		return number_format($number, $dec, ',', $sep);
	}

	public function removeWhiteSpace($str)
	{
		return preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $str);
	}

	public function addMinute($mulai,$minute)
	{
		$date_skrg = date_create($mulai);
		date_add($date_skrg, date_interval_create_from_date_string(($minute*60)." seconds"));
		return date_format($date_skrg, 'Y-m-d H:i:s');
	}

	public function fetchNominal($number)
	{
		return str_replace(",", "", $number);
	}

	public function fetchDatetime($datetime)
	{
		$d = explode(' ',$datetime);
		$d1 = explode('/',$d[0]);
		$d2 = array_reverse($d1);
		return implode('-',$d2)." ".$d[1];
	}

	public function unfetchDatetime($d)
	{
		$ex1 = explode(' ',$d);
 		$ex = explode('-',$ex1[0]);
 		return $ex[2]."/".$ex[1]."/".$ex[0]." ".$ex1[1];
	}

	public function bulan($b,$mode='')
	{
		$b = (int) $b;
        $bulan = config('bobb.ref_bulan'.$mode);
		if(!isset($bulan[$b])) return '-';
		return $bulan[$b];
	}
	public function listbulan()
	{
		for($i=1;$i<=12;$i++)
		{
			$data[$i] = $this->bulan($i);
		}
		return $data;
	}
	public function listtahun($min,$max)
	{
		for($i=$min;$i<=$max;$i++)
		{
			$data[$i] = $i;
		}
		return $data;
	}
	public function parseDate($date, $mode='')
	{
        if($mode != '')
            $mode = '_'.$mode;
		if(strlen($date) != 10) return '-';
		$dt = explode('-',$date);
		if(count($dt) != 3) return '-';
		if(!checkdate($dt[1],$dt[2],$dt[0])) return '-';
		return $dt[2]." ".$this->bulan($dt[1],$mode)." ".$dt[0];
	}
	public function parseDateTime($datetime)
	{
		if(strlen($datetime) != 19) return '-';
		$ex = explode(' ',$datetime);
		$dt = explode('-',$ex[0]);
		if(count($dt) != 3) return '-';
		if(!checkdate($dt[1],$dt[2],$dt[0])) return '-';
		return $dt[2]." ".$this->bulan($dt[1],"_singkat")." ".$dt[0]." ".$ex[1];
	}
	public function fetchTime($datetime)
	{
		if(strlen($datetime) != 19) return '-';
		$ex = explode(' ',$datetime);

		$dt = explode('-',$ex[0]);
		if(count($dt) != 3) return '-';
		if(!checkdate($dt[1],$dt[2],$dt[0])) return '-';

		return $ex[1];
	}
	public function parseDateRentang($date1,$date2)
	{
		if($date1 == $date2)
			return $this->parseDate($date1);
		$d1 = explode('-',$date1);
		$d2 = explode('-',$date2);
		if($d1[1] == $d2[1] && $d1[0] == $d2[0])
		{
			return $d1[2].' s.d '.$d2[2].' '.$this->bulan($d1[1]).' '.$d1[0];
		}
		return $this->parseDate($date1).' s.d '.$this->parseDate($date2);
	}
	public function hari($b)
	{
		$hari = config('bobb.hari');
		if(!isset($hari[$b])) return '-';
		return $hari[$b];
	}
    public function hariFromDate($date)
    {
        $tgl = date('D', strtotime($date));
        return $this->hari($tgl);
    }
	public function datetimediff($d1,$d2)
	{
		$datetime1 = date_create($d1);
		$datetime2 = date_create($d2);
		$interval = date_diff($datetime1,$datetime2);
		return [$interval->format('%h'),$interval->format('%i'),$interval->format('%s')];
	}
	public function inputMaskToDate($date)
	{
		$ex = explode(' ',$date);
		$ex1 = explode('/',$ex[0]);
		$ex1 = array_reverse($ex1);
		$ex[0] = implode('-',$ex1);

		return implode(' ',$ex);
	}
	public function seconddiff($d1,$d2)
	{
		$i = $this->datetimediff($d1,$d2);
		return ($i[0]*3600)+($i[1]*60)+($i[2]);
    }
	public function diffinseconds($d1,$d2)
	{
		$timeFirst  = strtotime($d1);
		$timeSecond = strtotime($d2);
		return abs($timeSecond - $timeFirst);
    }
    public function diffinhours($d1,$d2)
    {
        $sec = $this->diffinseconds($d1,$d2);
        return floor($sec / 3600);
    }

	function changeTimeZone($dateString, $timeZoneSource = null, $timeZoneTarget = null)
	{
		if (empty($timeZoneSource)) {
			$timeZoneSource = date_default_timezone_get();
		}
		if (empty($timeZoneTarget)) {
			$timeZoneTarget = date_default_timezone_get();
		}

		$dt = new \DateTime($dateString, new \DateTimeZone($timeZoneSource));
		$dt->setTimezone(new \DateTimeZone($timeZoneTarget));

		return $dt->format("Y-m-d H:i:s");
	}

	// display image
	public function getImage($path,$width='',$class='')
	{
		$filename = basename($path);
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
		switch( $file_extension ) {
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			default:
				$info = getimagesize($path);
				$ctype = $info['mime'];
		}
		$data = "data:".$ctype.";base64,".base64_encode(file_get_contents($path));
		if($width == "" && $class == "")
			return $data;
		return "<img width='$width' class='$class' src='$data' />";
	}

	public function getBlobFile($ref,$ref_id,$default,$width='',$class='')
	{
		$q = \DB::table('app_blob_files')
			->where('ref',$ref)
			->where('ref_id',$ref_id)
			->first();

		if(is_null($q))
		{
			if($default != "")
			{
				return $this->getImage($default,$width,$class);
			}
			else
			{
				return false;
			}
		}

		$data = "data:".$q->file_type.";base64,".base64_encode($q->file_blob);
		if($width == "" && $class == "")
			return $data;

		return "<img width='$width' class='$class' src='$data' />";
	}

	public function getUploadPath($basedir,$base_id='')
	{
		$permission = 0755;
		if($base_id != '')
		{
			$base = $basedir.$base_id.'/';
			$isdir = is_dir($base);
			if($isdir == false)
			{
				$old = umask(0);
				mkdir($base,$permission);
				umask($old);
			}
			return $base;
		}
		$nowday = date('d');
		$nowmonth = date('m');
		$nowyear = date('Y');
		$baseyear = $basedir.$nowyear.'/';
		$isdir = is_dir($baseyear);
		if($isdir == false)
		{
			$old = umask(0);
			mkdir($baseyear,$permission);
			umask($old);
		}
		$basemonth = $baseyear.$nowmonth.'/';
		$isdir = is_dir($basemonth);
		if($isdir == false)
		{
			$old = umask(0);
			mkdir($basemonth,$permission);
			umask($old);
		}
		$baseday = $basemonth.$nowday.'/';
		$isdir = is_dir($baseday);
		if($isdir == false)
		{
			$old = umask(0);
			mkdir($baseday,$permission);
			umask($old);
		}
		return $baseday;
	}
	public function getFile($path)
	{
		$filename = basename($path);
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
		switch( $file_extension ) {
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			default:
		}
		header('Content-type: ' . $ctype);
		readfile($path);
		exit;
	}
	/**
	* Converts an integer into the alphabet base (A-Z).
	*
	* @param int $n This is the number to convert.
	* @return string The converted number.
	* @author Theriault
	*
	*/
	public function num2alpha($n) {
		$r = '';
		for ($i = 1; $n >= 0 && $i < 10; $i++) {
		    $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
		    $n -= pow(26, $i);
		}
		return $r;
	}
	/**
	* Converts an alphabetic string into an integer.
	*
	* @param int $n This is the number to convert.
	* @return string The converted number.
	* @author Theriault
	*
	*/
	public function alpha2num($a) {
		$r = 0;
		$l = strlen($a);
		for ($i = 0; $i < $l; $i++) {
		    $r += pow(26, $i) * (ord($a[$l - $i - 1]) - 0x40);
		}
		return $r - 1;
	}

	// HTML Minifier
	function minify_html($input)
	{
	    if(trim($input) === "") return $input;
	    // Remove extra white-space(s) between HTML attribute(s)
	    $input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function($matches) {
	        return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
	    }, str_replace("\r", "", $input));
	    // Minify inline CSS declaration(s)
	    if(strpos($input, ' style=') !== false) {
	        $input = preg_replace_callback('#<([^<]+?)\s+style=([\'"])(.*?)\2(?=[\/\s>])#s', function($matches) {
	            return '<' . $matches[1] . ' style=' . $matches[2] . $this->minify_css($matches[3]) . $matches[2];
	        }, $input);
	    }
	    if(strpos($input, '</style>') !== false) {
	      $input = preg_replace_callback('#<style(.*?)>(.*?)</style>#is', function($matches) {
	        return '<style' . $matches[1] .'>'. $this->minify_css($matches[2]) . '</style>';
	      }, $input);
	    }
	    if(strpos($input, '</script>') !== false) {
	      $input = preg_replace_callback('#<script(.*?)>(.*?)</script>#is', function($matches) {
	        return '<script' . $matches[1] .'>'. $this->minify_js($matches[2]) . '</script>';
	      }, $input);
	    }
	    return preg_replace(
	        array(
	            // t = text
	            // o = tag open
	            // c = tag close
	            // Keep important white-space(s) after self-closing HTML tag(s)
	            '#<(img|input)(>| .*?>)#s',
	            // Remove a line break and two or more white-space(s) between tag(s)
	            '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
	            '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s', // t+c || o+t
	            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s', // o+o || c+c
	            '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s', // c+t || t+o || o+t -- separated by long white-space(s)
	            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s', // empty tag
	            '#<(img|input)(>| .*?>)<\/\1>#s', // reset previous fix
	            '#(&nbsp;)&nbsp;(?![<\s])#', // clean up ...
	            '#(?<=\>)(&nbsp;)(?=\<)#', // --ibid
	            // Remove HTML comment(s) except IE comment(s)
	            '#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s'
	        ),
	        array(
	            '<$1$2</$1>',
	            '$1$2$3',
	            '$1$2$3',
	            '$1$2$3$4$5',
	            '$1$2$3$4$5$6$7',
	            '$1$2$3',
	            '<$1$2',
	            '$1 ',
	            '$1',
	            ""
	        ),
	    $input);
	}

	function cleanHTML($html)
	{
	    $doc = new \DOMDocument();
	    /* Load the HTML */
	    $doc->loadHTML($html,
	            LIBXML_HTML_NOIMPLIED | # Make sure no extra BODY
	            LIBXML_HTML_NODEFDTD |  # or DOCTYPE is created
	            LIBXML_NOERROR |        # Suppress any errors
	            LIBXML_NOWARNING        # or warnings about prefixes.
	    );
	    /* Immediately save the HTML and return it. */
	    return $doc->saveHTML();
	}

	// CSS Minifier => http://ideone.com/Q5USEF + improvement(s)
	function minify_css($input)
	{
	    if(trim($input) === "") return $input;
	    return preg_replace(
	        array(
	            // Remove comment(s)
	            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
	            // Remove unused white-space(s)
	            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
	            // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
	            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
	            // Replace `:0 0 0 0` with `:0`
	            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
	            // Replace `background-position:0` with `background-position:0 0`
	            '#(background-position):0(?=[;\}])#si',
	            // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
	            '#(?<=[\s:,\-])0+\.(\d+)#s',
	            // Minify string value
	            '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
	            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
	            // Minify HEX color code
	            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
	            // Replace `(border|outline):none` with `(border|outline):0`
	            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
	            // Remove empty selector(s)
	            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
	        ),
	        array(
	            '$1',
	            '$1$2$3$4$5$6$7',
	            '$1',
	            ':0',
	            '$1:0 0',
	            '.$1',
	            '$1$3',
	            '$1$2$4$5',
	            '$1$2$3',
	            '$1:0',
	            '$1$2'
	        ),
	    $input);
	}
	// JavaScript Minifier
	function minify_js($input)
	{
	    if(trim($input) === "") return $input;
	    return preg_replace(
	        array(
	            // Remove comment(s)
	            '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
	            // Remove white-space(s) outside the string and regex
	            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
	            // Remove the last semicolon
	            '#;+\}#',
	            // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
	            '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
	            // --ibid. From `foo['bar']` to `foo.bar`
	            '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
	        ),
	        array(
	            '$1',
	            '$1$2',
	            '}',
	            '$1$3',
	            '$1.$3'
	        ),
	    $input);
	}

	function changeEnv($data = array())
	{
        if(count($data) > 0){

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);

            // Loop through given data
            foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
	}

	function compressImage($source, $destination, $quality)
	{
		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg')
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif')
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png')
		  	$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);
	}

	public function replaceBBcodes($text)
    {
    	#$text = strip_tags($text);
		// BBcode array
		$find = array(
			'~\[b\](.*?)\[/b\]~s',
			'~\[i\](.*?)\[/i\]~s',
			'~\[u\](.*?)\[/u\]~s',
			'~\[quote\]([^"><]*?)\[/quote\]~s',
			'~\[size=([^"><]*?)\](.*?)\[/size\]~s',
			'~\[color=([^"><]*?)\](.*?)\[/color\]~s',
			'~\[url\]((?:ftp|https?)://[^"><]*?)\[/url\]~s',
			'~\[img\](https?://[^"><]*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
			'~\[br\]~s',
		);
		// HTML tags to replace BBcode
		$replace = array(
			'<b>$1</b>',
			'<i>$1</i>',
			'<span style="text-decoration:underline;">$1</span>',
			'<pre>$1</'.'pre>',
			'<span style="font-size:$1px;">$2</span>',
			'<span style="color:$1;">$2</span>',
			'<a href="$1">$1</a>',
			'<img src="$1" alt="" />',
			'<br />',
		);
		// Replacing the BBcodes with corresponding HTML tags
		return preg_replace($find, $replace, $text);
    }

    public function imageUrl($filePath)
	{
        $image = 'https://via.placeholder.com/50';
		if ($filePath && file_exists( public_path().'/storage/'.$filePath ))
			$image = url('/storage/'.$filePath);

		return $image;
    }

    public function saveFilePondUpload($file, $folder)
    {
        $file = json_decode($file);
        $data = base64_decode($file->data);
        $fileName = explode('.',$file->name);
        $fileExt = end($fileName);
        $path = $folder.'/'.Str::random(40).'.'.$fileExt;
        $realPath = 'public/'.$path;

        if(Storage::disk('local')->put($realPath, $data))
        {
            return $path;
        }

        return false;
    }

    public function saveFileUpload($requestFile, $folderName, $file_ext = '', $prefix = '', $suffix = '')
	{
        $path = 'uploads/files/'.date('Y-m-d').'/'.$folderName;
        if(is_string($requestFile))
        {
            $contents = file_get_contents($requestFile);
            $outputFile = $path . '/' . $prefix . 'doc-' . Str::random(40) . $suffix . ($file_ext != '' ? '.'.$file_ext : '.pdf');
            Storage::disk('public')->put($outputFile, $contents);
            return $outputFile;
        }
        else
        {
            return $requestFile->storeAs(
                $path,
                Str::random(40).'.'.$requestFile->getClientOriginalExtension(),
                'public'
            );
        }
    }

    public function fileUrl($filePath, $forceUrl = false)
	{
		$data['exist'] = false;
		if ($filePath && file_exists( public_path().'/storage/'.$filePath )){
			$data['exist'] = true;
			$data['url'] = url('/storage/'.$filePath);
        }

        if($forceUrl)
        {
            return url('/storage/'.$filePath);
        }

		return $data;
	}

    public function strBoolean($val, $add_class = '', $key = 'ya_tidak')
    {
        return '<span class="badge bg-light-'.config('bobb.class_boolean')[(int) @$val].' '.$add_class.'">'.config('bobb.str_boolean.'.$key)[(int) @$val].'</span>';
    }

    public function strValid($val, $add_class = '')
    {
        return '<span class="badge bg-'.config('bobb.class_valid')[(int) @$val].' '.$add_class.'">'.config('bobb.str_valid')[(int) @$val].'</span>';
    }

    public function strHighlight($val, $class, $add_class = '')
    {
        return '<span class="badge bg-'.$class.' '.$add_class.'">'.$val.'</span>';
    }

    public function timeLeft($from, $to, $suffix = '')
    {
        if($from > $to)
        {
            $tmp = $from;
            $from = $to;
            $to = $tmp;
        }

        $from = new \DateTime($from);
        $to = new \DateTime($to);

        $interval = $to->diff($from);

        $str = '';
        if($interval->format('%a') > 0)
        {
            $str .= $interval->format('%a').' hari';
        }
        if($interval->format('%h') > 0)
        {
            $min = '';
            if($str != '')
            {
                $str .= ' ';
            }
            else
            {
                $min = ' '.intval($interval->format('%i')).' menit';
            }
            $str .= $interval->format('%h').' jam'.$min;
        }
        else
        {
            if($str == '')
            {
                $str .= ' '.intval($interval->format('%i')).' menit';
            }
        }

        if($str == '')
        {
            return '-';
        }
        return $str.' '.$suffix;
    }
}
