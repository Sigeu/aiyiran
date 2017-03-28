
    /**
     * 加载文本编辑器，加载失败情况下，给出提示
     * @param editorId 文本编辑器元素的ID，如果不传递此参数，默认为'content'
     * @param msgId 错误提示元素的ID，如果不传递此参数，默认为'fail'
     * @returns
     */
    function init(editorId, msgId)
    {
    	if(typeof editorId == 'undefined')
    	{
    		editorId = 'content';
    	}
    	if(typeof msgId == 'undefined')
    	{
    		msgId = 'fail';
    	}
    	if (typeof CKEDITOR == 'undefined')
    	{
    		$("#" + editorId).html("加载CKEditor失败!!");
    		$("#" + msgId).css("display", "none");
    	}
    	else 
    	{
    		CKEDITOR.replace(editorId,
    		{
    			toolbar :
    			[
    				//样式       格式      字体    字体大小
    				['Styles','Format','Font','FontSize'],
    				//加粗     斜体，     下划线      穿过线      下标字        上标字
    				['Bold','Italic','Underline']
    			],
				width:500,
				height:200
    		}
    		); 
    	}
    	
    }
