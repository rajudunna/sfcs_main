<?php echo " <chart lowerLimit='0' upperLimit='100' gaugeStartAngle='180' gaugeEndAngle='0' palette='1' numberSuffix='%' tickValueDistance='20' showValue='1' decimals='0' dataStreamURL='CPUData.asp' refreshInterval='3' preSuffix='%'>
   <colorRange>
      <color minValue='0' maxValue='50' code='FF654F'/>
      <color minValue='50' maxValue='75' code='F6BD0F'/>		
      <color minValue='75' maxValue='100' code='8BBA00'/>
   </colorRange>
   <dials>
      
	  <dial id='CPU1' value='63' rearExtension='15' bgcolor='33ff00' valueY='150'/>
   </dials>
   <styles>
      <definition>
         <style type='font' name='myValueFont' bgColor='ffffff' borderColor='999999' />
      </definition>
      <application>
         <apply toObject='Value' styles='myValueFont' />
      </application>
   </styles>
</chart>"; ?>