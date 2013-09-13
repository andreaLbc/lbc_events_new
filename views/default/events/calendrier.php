<div class="clearfloat"></div>
<script type="text/javascript">
$().ready(function() {
	
var dates=[];
<?php
$options = array(
	'types'	=> "object",
	'subtypes'	 =>  'events',
	'offset'	=> 0,
	'limit'	=> 9999,
	'full_view'	=> FALSE,
	'view_type_toggle'	=> FALSE,
	'pagination'	=> FALSE,
	);
	
$actus = elgg_get_entities($options);
$count = elgg_get_entities(array_merge(array('count'=>TRUE), $options));
$dateeven=array();
$i=0;

    foreach($actus as $actu){
    	$passdate=date('mdY',$actu->datedebut);   		
    	$detail .= "<div class='detail-calendrier ".$passdate."' style='display:none' >";
  		$detail .="<div class='contdate'><span class='day'>".date('d',$actu->datedebut);
		$detail .= "</span><span class='date'>".date('m Y',$actu->datedebut)."</span></div>";  	
     	$detail .= "<a href='".$actu->getUrl()."' class='event_calend'>";
		$detail .= crop_text($actu->title, 25);
     	$detail .= "</a>";
     	$detail .= "<a href='#' class='event_calend_close'></a>";
		$detail .= "</div><div class='clearfloat'></div>";
		?>
		dates[<?php echo $i; ?>] = new Date(<?php echo date('Y,n-1,j',$actu->datedebut); ?>);
		<?php
		$i++;
    }

?>

$('#datepicker').datepicker({ beforeShowDay: highlightDays, onSelect: SelectedDay, onChangeMonthYear: SelectedDay  });

function highlightDays(date) {
	for (var i = 0; i < dates.length; i++) {
        if (dates[i] <= date && dates[i] >= date) {
                return [true, 'ui-state-highlight'];
        }
	}
    return [false, ''];      
}

function SelectedDay(date, inst) {
	$('.detail-calendrier').hide();
	var passd=date[0]+date[1]+date[3]+date[4]+date[6]+date[7]+date[8]+date[9];
	$('.'+passd).show();
}

	$('.event_calend_close').click(function(){
		$(this).parent().hide();
		return false;
	});
});


</script>


<div class="sidebar_calendrier">

<div id="datepicker" style="margin-bottom:10px"></div>

<?php 
echo $detail;
?>
</div>
<div class="clearfloat"></div>



