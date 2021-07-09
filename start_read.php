<!-- Read a Voter Card -->
<div id="wrapper">
	<div class="container">
		<div class="row">
			<div id="showCard">
			<table>
<tbody>

<tr>
    <td style="width:400px; vertical-align:top">
        <div id="image1"></div>
    </td>
    <td colspan="5"  style="vertical-align:top;">

<table>
<tbody>
<tr>
<td><div id="image2"></div></td>
<td><div id="image3"></div></td>
</tr>
</tbody>
</table>        

<table>
<tbody>
<tr>
<td><div id="image4-1"></div></td>
<td><div id="image4-2"></div></td>
<td><div id="image4-3"></div></td>
<td><div id="image4-4"></div></td>
<td><div id="image4-5"></div></td>
</tr>
<tr>
<td><div id="image4-6"></div></td>
<td><div id="image4-7"></div></td>
<td><div id="image4-8"></div></td>
<td><div id="image4-9"></div></td>
<td><div id="image4-0"></div></td>
</tr>
</tbody>
</table>
    </td>
</tr>
<tr>
    <td colspan="6">
        <div id="image5"></div>
    </td>
</tr>

<tr>
    <td colspan="6">
        <input id="nextVoter" type="submit" class="hidden submit btn btn-success" value="Next Voter">
        <input type="hidden" id="page-state" value="">
    </td>
</tr>

</tbody>
</table>	
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {

    $.ajax({
            type: 'POST',
            url: '/api/',
            data: "action=showCard",
            success: function(data) {              
               	var json = $.parseJSON(data);
               	if(json.data != undefined && json.data.length != undefined){
               		var i = 0;

					$( "#image1" ).append( '<img class="image1" src="' + json.data[i].face_photo_1 + '" alt="" />' );
					$( "#image2" ).append( '<img class="image2-3" src="' + json.data[i].face_photo_2 + '" alt="" />' );
					$( "#image3" ).append( '<img class="image2-3" src="' + json.data[i].face_photo_3 + '" alt="" />' );
					$( "#image4-1" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-2" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-3" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-4" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-5" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-6" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-7" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-8" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-9" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-0" ).append( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image5" ).append( '<img class="signature" src="' + json.data[i].signature + '" alt="" />' );
		    		
				    if(json.pageState) { 
				    	$( "#nextVoter" ).removeClass("hidden"); 
				    	$( "#page-state" ).val(json.pageState);
				    } else { 
				    	$( "#nextVoter" ).addClass("hidden"); 
				    	$( "#page-state" ).val(json.pageState);
				    }
		       	}
		       	else {
		       		alert('No data here yet, load some and refresh this page.');
		       	}
            }
        });
    // i need to create a generic function to parse data object into images, that can pass into page load function above and click function below

    $('#nextVoter').click(function(e){
        e.preventDefault();
        var action = "showCard";
        var pagestate = $("#page-state").val();
        alert('Next Page State: ' + pagestate);
        $.ajax({
            type: "POST",
            url: "/api/",
            dataType: "json",
            data: {action:action,pagestate:pagestate},
            success: function(json) {              
               	if(json.count != undefined && json.count == 1){
               		var i = 0;

					$( "#image1" ).html( '<img class="image1" src="' + json.data[i].face_photo_1 + '" alt="" />' );
					$( "#image2" ).html( '<img class="image2-3" src="' + json.data[i].face_photo_2 + '" alt="" />' );
					$( "#image3" ).html( '<img class="image2-3" src="' + json.data[i].face_photo_3 + '" alt="" />' );
					$( "#image4-1" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-2" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-3" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-4" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-5" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-6" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-7" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-8" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-9" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image4-0" ).html( '<img class="fingerprint" src="' + json.data[i].fingerprint_left_index + '" alt="" />' );
					$( "#image5" ).html( '<img class="signature" src="' + json.data[i].signature + '" alt="" />' );

		       	}
		       	if(json.pageState) {
			    	$( "#nextVoter" ).removeClass("hidden"); 
			    	$( "#page-state" ).val(json.pageState);
			    } else { 
			    	$( "#nextVoter" ).addClass("hidden"); 
			    	$( "#page-state" ).val();
			    }
        }
        });
      });
  });
</script>