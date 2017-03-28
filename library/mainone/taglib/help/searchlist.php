
<?php return array (
'name' => 'searchlist',
'describe' => '搜索结果页',
'example'=>'
{mo:searchlist row="10" id="$ids" mid="$mid" cid="$cid" stat="$stat" search_type="$search_type" modelTab="$modelTab"  keyword="$keyword" pagesize="5" pagenum="5" return="data"} 
  		{foreach $data  $key $v}  
  			  <dl>
				  {if $v[\'mid\'] == 1}
					    <dt><a href="{$v[\'url\']}">{$v[\'title\']}</a><span>日期：{date(\'Y-m-d\',$v[\'created\'])}</span><span>点击量：{$v[\'hits\']}</span></dt>
				        <dd>{$v[\'description\']}</dd>
				  {elseif $v[\'mid\'] == 2}
				  		<dt><a href="{$v[\'url\']}">{$v[\'goodsname\']}</a><span>日期：{date(\'Y-m-d\',$v[\'created\'])}</span><span>点击量：{$v[\'hits\']}</span></dt>
				        <dd>{$v[\'brief\']}</dd>
				  {elseif  $v[\'mid\'] == "a"}
					    <dt><a href="{$v[\'url\']}">{$v[\'name\']}</a><span>日期：{date(\'Y-m-d\',$v[\'created\'])}</span></dt>
				        <dd>{$v[\'guide\']}</dd>
				  {else}
					    <dt><a href="{$v[\'url\']}">{$v[\'goodsname\']}{$v[\'name\']}{$v[\'title\']}</a><span>日期：{date(\'Y-m-d\',$v[\'created\'])}</span><span>点击量：{$v[\'hits\']}</span></dt>
				        <dd>{$v[\'guide\']}{$v[\'brief\']}{$v[\'subtitle\']}</dd>
				  {/if}
			  </dl>
  		{/foreach}
{/mo:searchlist} ',  
'params'=>array(
'row ="5"'=> '记录数目',
'return ="data"'=> '返回值名称：默认用data',	
'from="0"'=> '从开始开始记录',
'pagesize="10"'=> '每页显示10个',
),
);?>