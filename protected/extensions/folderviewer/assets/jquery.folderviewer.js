$(document).ready(function()
{

    var putImages=function()
    {
        ajaxrefreshfiles(function (data) {
            var folderviewerimagesfolder=data;
            var mainfolderblock=$('.folderviewer');
            if(Object.keys(folderviewerimagesfolder).length>0)
            {
                if($('.pop-up .nano .nano-content>div').length>0)
                    $('.pop-up .nano .nano-content').empty()
                for(file in folderviewerimagesfolder)
                {
                    var newimage=$('<div/>', {
                        class:'content-image',
                        html:'<input type="hidden" value="'+file+'" name="image-id"><img style="" src="'+folderviewerimagesfolder[file]+'" />'
                    })
                    $('.pop-up .nano .nano-content',mainfolderblock).append(newimage)
                    console.log(file,folderviewerimagesfolder[file])
                }
                if($('.pop-up .nano .nano-content>div').length>0)
                {
                    $('.pop-up .nano').nanoScroller();
                }

            }
        })
    },folderviewerbuttonhadler=null;
    $(document).on('click','.folderviewer-button',function()
    {
        folderviewerbuttonhadler=$(this);
        /*show popup window with*/
        var foldervback=$('<div/>', {
            class:'folderviewer-back'
        })
        var folderpopup=$('<div/>', {
            class:'pop-up'
        })
        /*tool bar*/
        var foldertool=$('<div/>', {
            class:'foldertool'
        })
        /*close-b*/
        var toolclosebutton=$('<div/>', {
            class:'close-b',
            text:'X'
        })
        /*add file button*/
        var addfilebutton=$('<div/>', {
            class:'add-file',
            text:'+',
            title:'Add new file'
         })
        /*refresh button*/
        var refreshfilebutton=$('<div/>', {
            class:'refresh-b',
            text:'R',
            title:'refresh files'
        })

        /*nano scroller*/
        var content=$('<div/>', {
            class:'nano',
            html:'<div class="nano-content"></div>'
        })
        /*without dublicates*/
        if($('.folderviewer').length>0)
        {
            $('.folderviewer').remove();
        }
        /**/
        $('<div/>', {
            class:'folderviewer'
        }).appendTo('body');
        if($('.folderviewer').length>0)
        {
            var mainfolderblock=$('.folderviewer')
            mainfolderblock.append(foldervback)
            mainfolderblock.append(folderpopup)
            if($('.pop-up',mainfolderblock).length>0)
            {
               $('.pop-up',mainfolderblock).append(foldertool)
                if($('.pop-up .foldertool',mainfolderblock).length>0)
                {
                    var toolvar=$('.pop-up .foldertool',mainfolderblock);
                    /*close button*/
                    toolvar.append(toolclosebutton);
                    /*add button*/
                    toolvar.append(addfilebutton);
                    /*refresh button*/
                    toolvar.append(refreshfilebutton);
                }
                $('.pop-up',mainfolderblock).append(content);
                if($('.pop-up .nano .nano-content',mainfolderblock))
                {
                    putImages()
                }

            }
        }
    }).on('click','.folderviewer .close-b',function()
    {
        if($('.folderviewer').length>0 || !$('.folderviewer').is(':visible'))
        {
            $('.folderviewer').remove();
        }
    }).on('click','.folderviewer .refresh-b',function()
    {
        putImages()
    }).on('click','.content-image',function()
    {
        var th=$(this),imageid=th.find('input[name=image-id]').val();
        folderviewerbuttonhadler.find('input[name*=image]').val(imageid);
        $('.folderviewer .close-b').trigger('click')
    })

})