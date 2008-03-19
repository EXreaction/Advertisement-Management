<script type="text/javascript">

	function countClick(id)
	{
	   loadXMLDoc('{ROOT_PATH}ads/click.php?a=' + id, ajaxCallback);
	}

	function loadXMLDoc(url, funcProcess) {
	   req = false;
	   if(window.XMLHttpRequest) {
	      try {
	         req = new XMLHttpRequest();
	      } catch(e) {
	         req = false;
	      }
	   } else if(window.ActiveXObject) {
	      try {
	         req = new ActiveXObject("Msxml2.XMLHTTP");
	      } catch(e) {
	         try {
	            req = new ActiveXObject("Microsoft.XMLHTTP");
	         } catch(e) {
	            req = false;
	         }
	      }
	   }
	   if(req) {
	      req.onreadystatechange = funcProcess;
	      req.open("GET", url, true);
	      req.send(null);
	   }
	}

	function ajaxCallback()
	 {
	   if (req.readyState == 4)
	   {
	      if (req.status == 200)
	      {
	         if (req.responseText.length)
	         {
	            if (req.responseText != '1')
	            {
	               alert('countClick Failed');
	            }
	         }
	      }
	      else
	      {
	         alert("There was a problem retrieving the XML data:\n" + req.statusText);
	      }
	   }
	}
</script>