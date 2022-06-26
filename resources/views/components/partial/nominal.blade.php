<script src="{{ asset('js/accounting/accounting.min.js') }}"></script>

<script type="text/javascript">
	function formatNumber(input) {
	    var num = input.value.replace(/\,/g, '');
	    if (!isNaN(num)) {
	        if (num.indexOf('.') > -1) {
	            num = num.split('.');
	            num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('').reverse().join('').replace(/^[\,]/, '');
	            if (num[1].length > 2) {
	                alert('You may only enter two decimals!');
	                num[1] = num[1].substring(0, num[1].length - 1);
	            }
	            input.value = num[0] + '.' + num[1];
	        } else {
	            input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1,').split('').reverse().join('').replace(/^[\,]/, '')
	        };
	    } else {
	        //alert('Anda hanya diperbolehkan memasukkan angka!');
	        input.value = input.value.substring(0, input.value.length - 1);
	    }
	}
	function format_number(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
	function convert_number(now=false)
	{
        var allNominalInput = document.querySelectorAll('.nominal');
        for (var i = 0; i < allNominalInput.length; i++) {
            if(now == true)
            {
                allNominalInput[i].value = accounting.formatNumber(allNominalInput[i].value);
            }
            allNominalInput[i].addEventListener('keyup', function(e){
                elm = e.target;
                var n = accounting.formatNumber(elm.value);
                if(n != 0)
                    elm.value = n;
            });
        }
    }

    (function() {
        convert_number(true);
    })();
</script>
