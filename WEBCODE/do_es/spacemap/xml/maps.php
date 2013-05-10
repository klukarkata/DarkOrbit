<?php include('../../includes/variables.php'); ?>
<?php header('Content-type: text/xml'); ?>
<maps>
<map id="1" name="1-1" music="6">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<neighbours>2</neighbours>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="1" pFactor="10" layer="0"/>	
	</backgrounds>	
	<lensflares>
   <lensflare id="1" x="310" y="408" pFactor="10" star="true"/>
	</lensflares>
	<planets>
		<planet typeID="1" x="400" y="400" pFactor="6" layer="1"/>
		<planet typeID="2" x="450" y="450" pFactor="5" layer="2"/>
	</planets>
</map>
<map id="2" name="1-2" music="0">
	  <gameserverIP><?php echo $HOST; ?></gameserverIP>
	  <neighbours>1,3,4,16</neighbours>
	  <starfield>true</starfield>
	  <backgrounds>
	 		<background typeID="2" layer="0"/>	
	 	</backgrounds>	
		<lensflares>
	   <lensflare id ="0" x="605" y="400" pFactor="10" star="true"/>
	   <lensflare id ="1" x="1654" y="861" pFactor="10" star="true"/>
	 </lensflares>
	 <planets>
	   <planet typeID ="3" x="492" y="266" pFactor="5" layer="1"/>
	   <planet typeID ="4" x="1808" y="792" pFactor="5" layer="2"/>
	</planets>
</map>
<map id="3" name="1-3" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="3" layer="0"/>	
	</backgrounds>	
	<lensflares>
	   <lensflare id ="0" x="720" y="644" pFactor="10" star="true"/>
	</lensflares>
	 <planets>
	   <planet typeID="13" x="474" y="832" pFactor="7" layer="1"/>
	</planets>
</map>
<map id="4" name="1-4" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="4" layer="0"/>	
	</backgrounds>	
	<lensflares>
	   <lensflare id ="0" x="1734" y="404" pFactor="10" star="false"/>
	</lensflares>
	 <planets>
	   <planet typeID="1" x="406" y="606" pFactor="7" layer="1"/>
	   <planet typeID="2" x="886" y="800" pFactor="5" layer="2"/>
	</planets>
</map>
<map id="5" name="2-1" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="5" layer="0"/>	
	</backgrounds>	
	<lensflares>
	   <lensflare id ="0" x="624" y="1064" pFactor="10" star="true"/>
	   <lensflare id ="1" x="1458" y="628" pFactor="10" star="true"/>
	</lensflares>
	 <planets>
		<planet typeID="15" x="1838" y="518" pFactor="9" layer="1"/>
	   <planet typeID="14" x="1686" y="884" pFactor="7" layer="2"/>
	   <planet typeID="16" x="648" y="1124" pFactor="8" layer="3"/>
	</planets>
</map>
<map id="6" name="2-2" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="6" layer="0"/>	
	</backgrounds>
	<lensflares>
	   <lensflare id ="0" x="624" y="1064" pFactor="10" star="true"/>
	   <lensflare id ="1" x="1458" y="628" pFactor="10" star="true"/>
	</lensflares>
	 <planets>
	   <planet typeID="17" x="1598" y="1011" pFactor="9" layer="1"/>
	   <planet typeID="18" x="1230" y="286" pFactor="8" layer="2"/>
	   <planet typeID="19" x="680" y="727" pFactor="7" layer="3"/>
	</planets>
</map>
<map id="7" name="2-3" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="7" layer="0"/>	
	</backgrounds>	
	<lensflares>
	   <lensflare id ="0" x="1928" y="184" pFactor="10" star="false"/>
	</lensflares>
	 <planets>
	   <planet typeID="20" x="547" y="718" pFactor="7" layer="1"/>
	   <planet typeID="21" x="1798" y="486" pFactor="7" layer="2"/>
	   <planet typeID="22" x="1772" y="552" pFactor="6" layer="3"/>
	</planets>
</map>
<map id="8" name="2-4" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="8" layer="0"/>	
	</backgrounds>	
	<lensflares>
	   <lensflare id ="0" x="306" y="172" pFactor="10" star="true"/>
	</lensflares>
	<planets>
	   <planet typeID="23" x="414" y="322" pFactor="7" layer="1"/>
	   <planet typeID="24" x="954" y="926" pFactor="7" layer="2"/>
	</planets>
</map>
<map id="9" name="3-1" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
		<backgrounds>
	 		<background typeID="9" pFactor="10" layer="0"/>
	 	</backgrounds>	
	<lensflares>
	   <lensflare id ="0" x="346" y="254" pFactor="10" star="true"/>
	   <lensflare id ="1" x="1449" y="773" pFactor="10" star="true"/>
	 </lensflares>
	 <planets>
		<planet typeID="11" x="1843" y="309" pFactor="8" layer="1"/>
	   <planet typeID="10" x="311" y="304" pFactor="7" layer="2"/>
	   <planet typeID="12" x="1522" y="884" pFactor="7" layer="3"/>
	</planets>
</map>
<map id="10" name="3-2" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="10"/>	
	</backgrounds>	
</map>
<map id="11" name="3-3" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="11"/>	
	</backgrounds>	
</map>
<map id="12" name="3-4" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="12"/>	
	</backgrounds>	
</map>
<map id="13" name="4-1" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="13"/>	
	</backgrounds>	
</map>
<map id="14" name="4-2" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="14" layer="0"/>	
	</backgrounds>	
	<lensflares>
		<lensflare id ="0" x="564" y="690" pFactor="10" star="true"/>
	</lensflares>
	<planets>
		<planet typeID="26" x="1742" y="962" pFactor="8" layer="1"/>
	   <planet typeID="25" x="346" y="872" pFactor="7" layer="2"/>
	   <planet typeID="27" x="1320" y="222" pFactor="7" layer="3"/>
	</planets>
</map>
<map id="15" name="4-3" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="15" layer="0"/>	
	</backgrounds>	
	<lensflares>
		<lensflare id ="0" x="1472" y="648" pFactor="10" star="true"/>
	</lensflares>
	<planets>
		<planet typeID="29" x="1534" y="654" pFactor="8" layer="1"/>
	   <planet typeID="28" x="288" y="996" pFactor="7" layer="2"/>
	</planets>
</map>
<map id="16" name="4-4" scaleFactor="2" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	 		<background typeID="16"/>	
	</backgrounds>	
</map>
<map id="17" name="1-5" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
	  <background typeID="17" layer="0"/>

	</backgrounds>	
	
</map>
<map id="18" name="1-6" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="18"/>	
	</backgrounds>	
</map>
<map id="19" name="1-7" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="19"/>	
	</backgrounds>	
</map>
<map id="20" name="1-8" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="20"/>	
	</backgrounds>
</map>
<map id="21" name="2-5" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="21"/>	
	</backgrounds>
</map>
<map id="22" name="2-6" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="22"/>	
	</backgrounds>
</map>
<map id="23" name="2-7" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="23"/>	
	</backgrounds>
	<lensflares>
		<lensflare id ="0" x="1324" y="992" pFactor="10" star="false"/>
	</lensflares>
</map>
<map id="24" name="2-8" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="24"/>	
	</backgrounds>
	<lensflares>
		<lensflare id ="0" x="966" y="716" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="25" name="3-5" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="25"/>	
	</backgrounds>
	<lensflares>
	   <lensflare id ="0" x="982" y="604" pFactor="10" star="true"/>
	 </lensflares>
</map>
<map id="26" name="3-6" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="26"/>	
	</backgrounds>
	<lensflares>
	   <lensflare id ="0" x="978" y="672" pFactor="10" star="false"/>
	 </lensflares>
</map>
<map id="27" name="3-7" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="27"/>	
	</backgrounds>
</map>
<map id="28" name="3-8" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="28"/>	
	</backgrounds>
	<lensflares>
		<lensflare id ="0" x="916" y="910" pFactor="10" star="false"/>
	  <lensflare id ="0" x="1290" y="404" pFactor="10" star="false"/>
	</lensflares>
</map>
<map id="29" name="4-5" scaleFactor="2" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="29" layer="0"/>	
	</backgrounds>
	<planets>
		<planet typeID="48" x="1190" y="1340" pFactor="1" layer="1"/>
		<planet typeID="48" x="2470" y="642" pFactor="1" layer="2"/>
		<planet typeID="48" x="2470" y="2084" pFactor="1" layer="3"/>
	</planets>
</map>
<map id="42" name="???" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="51" name="GG " music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="51" layer="0"/>	
	</backgrounds>
	<lensflares>
	   <lensflare id ="0" x="1100" y="968" pFactor="10" star="true"/>
	 </lensflares>
	 <planets>
	   <planet typeID="5" x="1230" y="822" pFactor="5" layer="1"/>
	   <planet typeID="6" x="1280" y="746" pFactor="3" layer="2"/>
	</planets>
</map>
<map id="52" name="GG " music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="52" layer="0"/>	
	</backgrounds>
	<lensflares>
	   <lensflare id ="0" x="950" y="650" pFactor="10" star="true"/>
	 </lensflares>
	 <planets>
	   <planet typeID="7" x="1950" y="1142" pFactor="9"  layer="1"/>
	   <planet typeID="8" x="1132" y="568" pFactor="7" layer="2"/>
	</planets>
</map>
<map id="53" name="GG " music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="53" layer="0"/>	
	</backgrounds>
	<lensflares>
	   <lensflare id ="0" x="1222" y="932" pFactor="10" star="true"/>
	 </lensflares>
	 <planets>
	   <planet typeID="9" x="1144" y="904" pFactor="7" layer="1"/>
	</planets>
</map>
<map id="54" name="GG NC" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="54" layer="0"/>	
	</backgrounds>
	<lensflares>
	   <lensflare id ="0" x="1222" y="932" pFactor="10" star="true"/>
	 </lensflares>
	 <planets>
	   <planet typeID="9" x="1144" y="904" pFactor="7" layer="1"/>
	</planets>
</map>
<map id="55" name="GG " music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="55" layer="0"/>	
	</backgrounds>
	<lensflares>
	   <lensflare id ="0" x="1222" y="932" pFactor="10" star="true"/>
	 </lensflares>
	 <planets>
	   <planet typeID="9" x="1144" y="904" pFactor="7" layer="1"/>
	</planets>
</map>
<map id="56" name="Galaxy Gate 6" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="56" layer="0"/>	
	</backgrounds>
	<lensflares>
	   <lensflare id ="0" x="1222" y="932" pFactor="10" star="true"/>
	 </lensflares>
	 <planets>
	   <planet typeID="9" x="1144" y="904" pFactor="7" layer="1"/>
	</planets>
</map>
<map id="57" name="GG Y4" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="57" layer="0"/>	
	</backgrounds>	
	<lensflares>
	   <lensflare id ="0" x="624" y="1064" pFactor="10" star="true"/>
	   <lensflare id ="1" x="1458" y="628" pFactor="10" star="true"/>
	</lensflares>
	 <planets>
	   <planet typeID="33" x="1734" y="357" pFactor="10" layer="1"/>
	   <planet typeID="43" x="1050" y="655" pFactor="6" layer="2"/>
	   <planet typeID="42" x="1050" y="655" pFactor="7" layer="3"/>
	   <planet typeID="41" x="1050" y="655" pFactor="8" layer="4"/>
	   <planet typeID="40" x="1050" y="655" pFactor="9" layer="5"/>
	   
	   <planet typeID="34" x="275" y="952" pFactor="4" layer="6"/>
	   <planet typeID="35" x="404" y="438" pFactor="3" layer="7"/>
	   <planet typeID="36" x="942" y="650" pFactor="3" layer="8"/>
	   <planet typeID="37" x="1307" y="299" pFactor="3" layer="9"/>	   
	   <planet typeID="38" x="1508" y="700" pFactor="3" layer="10"/>
	   <planet typeID="39" x="825" y="1056" pFactor="4" layer="11"/>
	   
	   <planet typeID="34" rotation="-45" x="375" y="852" pFactor="4" layer="12"/>
	   <planet typeID="35" rotation="-90" x="1734" y="908" pFactor="3" layer="13"/>
	   <planet typeID="36" rotation="180" x="742" y="550" pFactor="3" layer="14"/>
	   <planet typeID="37" rotation="-30" x="1000" y="200" pFactor="3" layer="15"/>	   
	   <planet typeID="38" rotation="45" x="1200" y="600" pFactor="3" layer="16"/>
	   <planet typeID="39" rotation="90" x="600" y="900" pFactor="4" layer="17"/>
	   <planet typeID="34" rotation="-90" x="275" y="752" pFactor="4" layer="18"/>
	   <planet typeID="37" rotation="-30" x="1000" y="200" pFactor="3" layer="19"/>	 
	   <planet typeID="38" rotation="-90" x="1508" y="1056" pFactor="3" layer="20"/>
	   <planet typeID="35" rotation="-90" x="1734" y="908" pFactor="3" layer="21"/>
	   <planet typeID="39" rotation="-90" x="1434" y="1000" pFactor="3" layer="22"/>
	   <planet typeID="36" rotation="-90" x="950" y="900" pFactor="3" layer="23"/>
		
	</planets>
</map>
<map id="61" name="Invasion" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="61" layer="0"/>
	</backgrounds>
	<planets>
		<planet typeID="30" x="694" y="560" pFactor="6" layer="1"/>
		<planet typeID="31" x="1974" y="1022" pFactor="6" layer="2"/>
		<planet typeID="32" x="1118" y="370" pFactor="5" layer="3"/>
	</planets>
	<lensflares>
		<lensflare id ="0" typeID="1" x="1682" y="210" pFactor="10" star="true"/>
		<lensflare id ="1" typeID="2" x="658" y="1090" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="62" name="Invasion" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="62" layer="0"/>
	</backgrounds>
	<planets>
		<planet typeID="30" x="694" y="560" pFactor="6" layer="1"/>
		<planet typeID="31" x="1974" y="1022" pFactor="6" layer="2"/>
		<planet typeID="32" x="1118" y="370" pFactor="5" layer="3"/>
	</planets>
	<lensflares>
		<lensflare id ="0" typeID="1" x="1682" y="210" pFactor="10" star="true"/>
		<lensflare id ="1" typeID="2" x="658" y="1090" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="63" name="Invasion" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="63" layer="0"/>
	</backgrounds>
	<planets>
		<planet typeID="30" x="694" y="560" pFactor="6" layer="1"/>
		<planet typeID="31" x="1974" y="1022" pFactor="6" layer="2"/>
		<planet typeID="32" x="1118" y="370" pFactor="5" layer="3"/>
	</planets>
	<lensflares>
		<lensflare id ="0" typeID="1" x="1682" y="210" pFactor="10" star="true"/>
		<lensflare id ="1" typeID="2" x="658" y="1090" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="64" name="Invasion" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="64" layer="0"/>
	</backgrounds>
	<planets>
		<planet typeID="30" x="694" y="560" pFactor="6" layer="1"/>
		<planet typeID="31" x="1974" y="1022" pFactor="6" layer="2"/>
		<planet typeID="32" x="1118" y="370" pFactor="5" layer="3"/>
	</planets>
	<lensflares>
		<lensflare id ="0" typeID="1" x="1682" y="210" pFactor="10" star="true"/>
		<lensflare id ="1" typeID="2" x="658" y="1090" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="65" name="Invasion" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="65" layer="0"/>
	</backgrounds>
	<planets>
		<planet typeID="30" x="694" y="560" pFactor="6" layer="1"/>
		<planet typeID="31" x="1974" y="1022" pFactor="6" layer="2"/>
		<planet typeID="32" x="1118" y="370" pFactor="5" layer="3"/>
	</planets>
	<lensflares>
		<lensflare id ="0" typeID="1" x="1682" y="210" pFactor="10" star="true"/>
		<lensflare id ="1" typeID="2" x="658" y="1090" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="66" name="Invasion" music="0"> 
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="66" layer="0"/>
	</backgrounds>
	<planets>
		<planet typeID="30" x="694" y="560" pFactor="6" layer="1"/>
		<planet typeID="31" x="1974" y="1022" pFactor="6" layer="2"/>
		<planet typeID="32" x="1118" y="370" pFactor="5" layer="3"/>
	</planets>
	<lensflares>
		<lensflare id ="0" typeID="1" x="1682" y="210" pFactor="10" star="true"/>
		<lensflare id ="1" typeID="2" x="658" y="1090" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="67" name="Invasion" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="67" layer="0"/>
	</backgrounds>
	<planets>
		<planet typeID="30" x="694" y="560" pFactor="6" layer="1"/>
		<planet typeID="31" x="1974" y="1022" pFactor="6" layer="2"/>
		<planet typeID="32" x="1118" y="370" pFactor="5" layer="3"/>
	</planets>
	<lensflares>
		<lensflare id ="0" typeID="1" x="1682" y="210" pFactor="10" star="true"/>
		<lensflare id ="1" typeID="2" x="658" y="1090" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="68" name="Invasion" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="68" layer="0"/>
	</backgrounds>
	<planets>
		<planet typeID="30" x="694" y="560" pFactor="6" layer="1"/>
		<planet typeID="31" x="1974" y="1022" pFactor="6" layer="2"/>
		<planet typeID="32" x="1118" y="370" pFactor="5" layer="3"/>
	</planets>
	<lensflares>
		<lensflare id ="0" typeID="1" x="1682" y="210" pFactor="10" star="true"/>
		<lensflare id ="1" typeID="2" x="658" y="1090" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="69" name="Invasion" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="69" layer="0"/>
	</backgrounds>
	<planets>
		<planet typeID="30" x="694" y="560" pFactor="6" layer="1"/>
		<planet typeID="31" x="1974" y="1022" pFactor="6" layer="2"/>
		<planet typeID="32" x="1118" y="370" pFactor="5" layer="3"/>
	</planets>
	<lensflares>
		<lensflare id ="0" typeID="1" x="1682" y="210" pFactor="10" star="true"/>
		<lensflare id ="1" typeID="2" x="658" y="1090" pFactor="10" star="true"/>
	</lensflares>
</map>
<map id="81" name="TDM I" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="81"/>	
	</backgrounds>
</map>
<map id="82" name="TDM II>" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="82"/>	
	</backgrounds>
</map>
<map id="91" name="5-1" scaleFactor="2" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield>true</starfield>
	<minimap typeID="91"/>
	<backgrounds>
		<background typeID="2001" pFactor="10" layer="0" hideLensflare="false" scale="1.6"/>
		<background typeID="1091" pFactor="10" isMain="true" layer="1"/>
		<background typeID="2024" pFactor="7" layer="3" hideLensflare="false" maskID="1"/>
		<background typeID="2011" pFactor="6" layer="4" hideLensflare="false" maskID="2"/>
		<background typeID="2022" pFactor="4" layer="5" hideLensflare="false" maskID="3"/>
		<background typeID="2022" pFactor="4" layer="6" shiftX="128" hideLensflare="false" maskID="3"/>
	</backgrounds>
	<lensflares>
		<lensflare id="0" x="900" y="920" pFactor="10" star="true"/>
	</lensflares>
	<planets>
		<planet typeID="44" x="800" y="800" pFactor="8" layer="2"/>
		<planet typeID="48" x="490" y="690" pFactor="1" layer="7"/>
		<planet typeID="48" x="260" y="1360" pFactor="1" layer="8"/>
		<planet typeID="48" x="490" y="2070" pFactor="1" layer="9"/>
	</planets>
</map>
<map id="92" name="5-2" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield color="0x333333">true</starfield>
	<backgrounds>
		<background typeID="2001" pFactor="10" layer="0" hideLensflare="false" scale="2.2" maskID="4"/>
		<background typeID="92" layer="1" pFactor="10" isMain="true" />
		<background typeID="2024" pFactor="7" layer="3" hideLensflare="false" scale="1.6" maskID="5"/>
		<background typeID="2011" pFactor="6" layer="4" hideLensflare="false" maskID="6"/>
		<background typeID="2022" pFactor="4" layer="5" shiftX="200" shiftY="200" hideLensflare="false" scale="1.6" maskID="7"/>
	</backgrounds>
	<lensflares>
		<lensflare id="0" x="1410" y="500" pFactor="10" star="true"/>
	</lensflares>
	<planets>
		<planet typeID="45" x="1050" y="0" pFactor="8" layer="2"/>
		<planet typeID="48" x="250" y="370" pFactor="1" layer="6"/>
		<planet typeID="48" x="100" y="685" pFactor="1" layer="7"/>
		<planet typeID="48" x="250" y="1100" pFactor="1" layer="8"/>
	</planets>
</map>
<map id="93" name="5-3" scaleFactor="2" music="0">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<starfield color="0xE3E3E3">true</starfield>
	<minimap typeID="93"/>
	<backgrounds>
		<background typeID="2001" pFactor="10" layer="0" hideLensflare="false" scale="1.6"/>
		<background typeID="1093" pFactor="10" layer="1" isMain="true"/>
		<background typeID="2024" pFactor="7" layer="3" hideLensflare="false" maskID="8"/>
		<background typeID="4001" pFactor="4" layer="4" hideLensflare="true" shiftX="3200" shiftY="4000" scale="1"/>
		<background typeID="2022" pFactor="4" layer="5" hideLensflare="false" maskID="9"/>
	</backgrounds>
	<lensflares>
		<lensflare id="3" x="1770" y="1660" pFactor="10" star="true"/>
	</lensflares>
	<planets>
		<planet typeID="46" x="3400" y="820" pFactor="8" layer="2"/>
		<planet typeID="49" x="164" y="966" pFactor="1" layer="6"/>
		<planet typeID="49" x="164" y="1366" pFactor="1" layer="7"/>
		<planet typeID="49" x="164" y="1766" pFactor="1" layer="8"/>
	</planets>
</map>
<map id="101" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.190.218</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="102" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.190.218</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="103" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.187.35</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="104" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.179</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="105" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.181</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="106" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.186</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="107" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.187.100</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="109" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.185</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="110" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.190.56</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="111" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.190.220</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="112" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.190.218</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="113" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.186</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="114" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.190.220</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="115" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.180</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="116" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.187.36</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="117" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.187.35</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="118" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.184</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="119" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.190.41</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="120" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.191</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="121" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.190.42</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="122" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.179</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="123" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.187.36</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="124" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.182</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="125" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.190.63</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="126" name="JP" scaleFactor="1" music="0">
	<gameserverIP>62.146.191.181</gameserverIP>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="42"/>	
	</backgrounds>
</map>
<map id="200" name="Lord of War" music="0">  
	<gameserverIP><?php echo $HOST; ?></gameserverIP>  
	<starfield>true</starfield>  
	<backgrounds>  
	  <background typeID="200" layer="0" isMain="true"/> 
	  <background typeID="1001" pFactor="9" layer="1" hideLensflare="true"/>  
	  <background typeID="1002" pFactor="7" layer="2" hideLensflare="true"/> 
	  <background typeID="1003" pFactor="6" layer="3" hideLensflare="true"/>  
	</backgrounds> 
</map>
<map id="255" name="0-1" music="0" scaleFactor="0.5">
	<gameserverIP><?php echo $HOST; ?></gameserverIP>
	<neighbours></neighbours>
	<starfield>true</starfield>
	<backgrounds>
		<background typeID="255"/>	
	</backgrounds>	 
</map>
</maps>