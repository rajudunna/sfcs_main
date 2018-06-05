<?php

# Arvin Castro, arvin@sudocode.net
# http://sudocode.net/sources/includes/class-omime-php/
# January 24, 2011
require 'class.extensionmime.php';

class omime {

    var $parts = array();
    var $attachments = array();
    var $boundary;
    var $type;
    var $rn = "\r\n";

    function omime($type = 'mixed') {
        $this->boundary = md5(time()).md5(mt_rand());
        $this->type     = $type;
    }

    function create($type = 'mixed') {
        return new omime($type);
    }

    function addMultipart($mime) { return $this->attachMultipart($mime); }
    function attachMultipart($mime) {
        $part = 'Content-Type: multipart/'.$mime->type.';'.$this->rn;
        $part.= "\t".'boundary='.$mime->boundary.$this->rn.$this->rn;
        $part.= $mime->combineParts();

        $this->parts[] = $part;
        return true;
    }

    function addHTML($html) { return $this->attachHTML($html); }
    function attachHTML($html) {
        return $this->attachText($html, 'html');
    }

    function addText($text, $subtype = 'plain') { return $this->attachText($text, $subtype); }
    function attachText($text, $subtype = 'plain') {
        $part = 'Content-Type: text/'.$subtype.$this->rn;
        $part.= 'Content-Transfer-Encoding: quoted-printable'.$this->rn.$this->rn;
        # $part.= wordwrap(imap_8bit($text), 70, $this->rn, true);
        // $part.= imap_8bit($text);

        $this->parts[] = $part;
        return true;
    }

    function addFile($path, $name = null, $type = null) { return $this->attachFile($path, $name=null, $type=null); }
    function attachFile($path, $name = null, $type = null) {
        if(file_exists($path)) {
	        if(!$name) $name = basename($path);
	        return $this->attachURI($path, $name, $type);
        }
        return false;
    }

    function addURL($url, $name = null, $type = null) { return $this->attachURL($url, $name, $type); }
    function attachURL($url, $name = null, $type = null) {
		if(!$name) $name  = urldecode(basename(parse_url($url, PHP_URL_PATH)));
        return $this->attachURI($url, $name, $type);
    }

    function attachURI($uri, $name, $type = null) {

	    if(!$type) $type = self::getMIMEByBasename($name);

	    $contentID = time().sha1($uri).mt_rand();
        $part = 'Content-Type: '.$type.'; name="'.$name.'"'.$this->rn;
        //$part.= 'Content-Disposition: attachment; filename="'.$name.'"'.$this->rn;
        $part.= 'Content-Transfer-Encoding: base64'.$this->rn;
        $part.= 'Content-ID: <'.$contentID.'>'.$this->rn;
        $part.= 'X-Attachment-Id: '.$contentID.$this->rn.$this->rn;
        $part.= wordwrap(base64_encode(file_get_contents($uri)), 76, $this->rn, true);

        $this->attachments[] = $part;
        return $contentID;
    }

    function attachPart($data, $name, $type) {
	    $contentID = time().md5(mt_rand());
        $part = 'Content-Type: '.$type.'; name="'.$name.'"'.$this->rn;
        //$part.= 'Content-Disposition: attachment; filename="'.$name.'"'.$this->rn;
        $part.= 'Content-Transfer-Encoding: base64'.$this->rn;
        $part.= 'Content-ID: <'.$contentID.'>'.$this->rn;
        $part.= 'X-Attachment-Id: '.$contentID.$this->rn.$this->rn;
        $part.= wordwrap(base64_encode($data), 76, $this->rn, true);

        $this->attachments[] = $part;
        return $contentID;
    }

    function combineParts() {
	    $body = '--'.$this->boundary.$this->rn;
        $body.= implode($this->rn.'--'.$this->boundary.$this->rn, $this->parts);
        if(count($this->attachments)) {
	        $body.= $this->rn.'--'.$this->boundary.$this->rn;
    		$body.= implode($this->rn.'--'.$this->boundary.$this->rn, $this->attachments);
		}
        $body.= $this->rn.'--'.$this->boundary.'--'.$this->rn;

        return $body;
    }

    function send($to, $subject, $headers = '', $parameters = '') {

        if(is_array($headers)) {
	        if(isset($headers[0]))
	        	$headers = implode($this->rn, $headers);
         	else $headers = self::assocToHeaders($headers);
     	}

        $headers = trim($headers);
        $headers.= $this->rn.'MIME-Version: 1.0'.$this->rn;
        $headers.= 'Content-type: multipart/'.$this->type.';'.$this->rn;
        $headers.= "\t".'boundary='.$this->boundary.$this->rn;

        $body = $this->combineParts();

        return mail($to, $subject, $body, $headers, $parameters);
    }

    function assocToHeaders($assoc) {
	    $headers = '';
	 	foreach($assoc as $key => $value) $headers .= $key.': '.$value.$this->rn;
	 	return $headers;
    }

    function getMIMEByBasename($path) {
	 	return ExtensionMIME::get($path);
    }
}
?>