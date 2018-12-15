<?php echo " <chart lineThickness='4' showValues='0' formatNumberScale='0' anchorRadius='4' divLineAlpha='20' divLineColor='8AA01D' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridColor='CC3300' shadowAlpha='40' labelStep='1' numvdivlines='10' chartRightMargin='35' bgColor='FFFFFF,CC3300' bgAngle='270' bgAlpha='10,10' showYAxisValues='0' yAxisMinValue='0' yAxisMaxValue='4500'><categories ><category label='2' /><category label='3' /><category label='4' /><category label='5' /><category label='6' /><category label='7' /><category label='10' /><category label='11' /><category label='12' /><category label='13' /><category label='14' /><category label='25' /><category label='26' /><category label='27' /><category label='28' /></categories>
<dataset seriesName='Plan SAH' color='F1683C' anchorBorderColor='F1683C' anchorBgColor='F1683C'></dataset>

<dataset seriesName='Actual SAH' color='2AD62A' anchorBorderColor='2AD62A' anchorBgColor='2AD62A'></dataset>

<trendLines>
<line startValue='500' color='FF0000' displayvalue='500' />
<line startValue='1100' color='FF0000' displayvalue='1,100' />
<line startValue='2200' color='000000' displayvalue='2,200' />
<line startValue='4000' color='000000' displayvalue='4,000' />
</trendLines>

	<styles>                
		<definition>
                         
			<style name='CaptionFont' type='font' size='12'/>
		</definition>
		<application>
			<apply toObject='CAPTION' styles='CaptionFont' />
			<apply toObject='SUBCAPTION' styles='CaptionFont' />
		</application>
	</styles>

</chart>"; ?>