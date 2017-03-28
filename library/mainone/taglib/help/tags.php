
<?php return array (
'name' => 'tags',
'describe' => 'Tag标签 - 文章',
'example'=>'
{mo:tags row="10" id="$keyids" return="data"} 
  		{foreach $data  $key $value}  
  			<tr class="bggreen"> 
    		  <td width="60%" class="left"><a href="{$value[\'url\']}">{$value[\'title\']}</a></td>
   			  <td width="20%">{date(\'Y-m-d\',$value[\'created\'])}</td>
   			</tr>
  		{/foreach}
{/mo:tags}',  
'params'=>array(
'row ="5"'=> '记录数目',
'return ="data"'=> '返回值名称：默认用data',	
'from="0"'=> '从开始开始记录',
'pagesize="10"'=> '每页显示10个',
),
);?>