/*
**
**	GalleryView - jQuery Content Gallery Plugin
**	Author: 		Jack Anderson
**	Version:		3.0 (March 23, 2010)
**
**	Please use this development script if you intend to make changes to the
**	plugin code.  For production sites, please use jquery.galleryview-2.1-pack.js.
**
**  See README.txt for instructions on how to markup your HTML
**
**	See CHANGELOG.txt for a review of changes and LICENSE.txt for the applicable
**	licensing information.
**
*/
var window_loaded=false;
$(window).load(function(){
    window_loaded=true;
});

(function($){
    $.fn.galleryView=function(options){

        var opts=$.extend($.fn.galleryView.defaults,options);
        var id;
        var iterator=0;
        var item_count=0;
        var slide_method;
        var theme_path;
        var paused=false;
        var pointer_speed=0;
        var animate_panels=true;
        var current=1;
        var gallery_images;
        var image_count=0;
        var loaded_images=0;
        var gallery_width;
        var gallery_height;
        var pointer_height;
        var pointer_width;
        var strip_width;
        var strip_height;
        var wrapper_width;
        var wrapper_height;
        var f_frame_width;
        var f_frame_height;
        var frame_caption_size=20;
        var filmstrip_orientation;
        var frame_img_scale={};
        var panel_img_scale={};
        var img_h={};
        var img_w={};
        var scale_panel_images=true;
        var panel_nav_displayed=false;
        var j_gallery;
        var j_filmstrip;
        var j_frames;
        var j_frame_img_wrappers;
        var j_panels;
        var j_pointer;
        var j_panel_wrapper;

        function showItem(i,speed,callback){
            var mod_i=i%item_count;
            var distance;
            var diststr;
            $('.nav-next, .nav-next-overlay, .panel-nav-next, .nav-prev, .nav-prev-overlay, .panel-nav-prev',j_gallery).unbind('click');
            j_frames.unbind('click');
            $(document).oneTime(speed,'bindNavButtons',function(){
                $('.nav-next, .nav-next-overlay, .panel-nav-next',j_gallery).click(showNextItem);
                $('.nav-prev, .nav-prev-overlay, .panel-nav-prev',j_gallery).click(showPrevItem);
                enableFrameClicking();
            });
            if(opts.show_filmstrip){
                j_frames.removeClass('current').find('img').stop().animate({
                    opacity:opts.frame_opacity
                },speed);
                j_frames.eq(i).addClass('current').find('img').stop().animate({
                    opacity:1
                },speed);
            }
            if(opts.show_panels){
                if(animate_panels){
                    if(opts.panel_animation=='slide'){
                        j_panels.eq(mod_i).css({
                            left:getInt($('.panel.current').eq(0).css('left'))+opts.panel_width+'px',zIndex:50
                        }).show().animate({
                            left:'-='+opts.panel_width+'px'
                        },speed,opts.easing,function(){
                            $(this).addClass('current');
                        });
                        $('.panel.current').css({
                            zIndex:49
                        }).animate({left:'-='+opts.panel_width+'px'},speed,opts.easing,function(){
                            $(this).removeClass('current').hide();
                        });
                    }else if(opts.panel_animation=='zoomOut'){
                        $(document).oneTime(speed,'setCurrentFrame',function(){
                            j_panels.eq(mod_i).addClass('current').css('zIndex',50);
                        });
                        j_panels.eq(mod_i).show().css('zIndex',49);
                        $('.panel.current img').animate({
                            top:'-='+opts.panel_height/2+'px',left:'-='+opts.panel_width/2+'px'
                        },speed,'swing', function(){
                            $(this).animate({
                                top:'+='+opts.panel_height/2+'px',left:'+='+opts.panel_width/2+'px'
                            },0);
                        });
                        $('.panel.current').animate({
                            top:'+='+opts.panel_height/2+'px',left:'+='+opts.panel_width/2+'px',height:0,width:0
                        },speed,'swing', function(){
                            $(this).removeClass('current').hide().css({
                                top:getPos(j_panels[mod_i]).top+'px',left:getPos(j_panels[mod_i]).left+'px',height:opts.panel_height+'px',width:opts.panel_width+'px'
                            });
                        });
                    }else if(opts.panel_animation=='crossfade'){
                        j_panels.removeClass('current').fadeOut(speed).eq(mod_i).addClass('current').fadeIn(speed);
                    }else{
                        j_panels.removeClass('current').stop().fadeOut(speed/2);
                        $(document).oneTime(speed/2,'fadeInPanel',function(){
                            j_panels.eq(mod_i).addClass('current').stop().fadeIn(speed/2);
                        });
                    }
                }else{
                    $(document).oneTime(speed,'switch_panels',function(){
                        j_panels.hide().eq(mod_i).show();
                    });
                }
            }

            if(opts.show_filmstrip){
                if(opts.filmstrip_style=='scroll'&&slide_method=='strip'){
                    j_filmstrip.stop();
                    if(filmstrip_orientation=='horizontal'){
                        distance=getPos(j_frames[i]).left-(getPos(j_pointer[0]).left+(pointer_width/2)-(f_frame_width/2));
                        diststr=(distance>=0?'-=':'+=')+Math.abs(distance)+'px';
                        j_filmstrip.animate({
                            left:diststr
                        },speed,opts.easing, function(){
                            var old_i=i;
                            if(i>item_count){
                                i=mod_i;
                                iterator=i;
                                j_filmstrip.css('left','-'+((f_frame_width+opts.frame_gap)*i)+'px');
                            }else if(i<=(item_count-strip_size)){
                                i=(mod_i)+item_count;
                                iterator=i;
                                j_filmstrip.css('left','-'+((f_frame_width+opts.frame_gap)*i)+'px');
                            }
                            if(old_i!=i){
                                j_frames.eq(old_i).removeClass('current').find('img').css({
                                    opacity:opts.frame_opacity
                                });
                                j_frames.eq(i).addClass('current').find('img').css({
                                    opacity:1
                                });
                            }
                        });
                    }else{
                        distance=getPos(j_frames[i]).top-getPos($('.strip_wrapper',j_gallery)[0]).top;
                        diststr=(distance>=0?'-=':'+=')+Math.abs(distance)+'px';
                        j_filmstrip.animate({
                            'top':diststr
                        },speed,opts.easing, function(){
                            var old_i=i;
                            if(i>item_count){
                                i=mod_i;
                                iterator=i;
                                j_filmstrip.css('top','-'+((f_frame_height+opts.frame_gap)*i)+'px');
                            }else if(i<=(item_count-strip_size)){
                                i=(mod_i)+item_count;
                                iterator=i;
                                j_filmstrip.css('top','-'+((f_frame_height+opts.frame_gap)*i)+'px');
                            }
                            if(old_i!=i){
                                j_frames.eq(old_i).removeClass('current').find('img').css({
                                    opacity:opts.frame_opacity
                                });
                                j_frames.eq(i).addClass('current').find('img').css({
                                    opacity:1
                                });
                            }
                            if(!animate_panels){
                                j_panels.hide().eq(mod_i).show();
                            }
                        });
                    }

                }else if(slide_method=='pointer'){
                    j_pointer.stop();
                    var pos=getPos(j_frames[i]);
                    if(filmstrip_orientation=='horizontal'){
                        j_pointer.animate({
                            left:pos.left+(f_frame_width/2)-(pointer_width/2)+'px'
                        } ,pointer_speed,opts.easing,function(){
                            if(!animate_panels){
                                j_panels.hide().eq(mod_i).show();
                            }
                        });
                    }else{
                        j_pointer.animate({
                            top:pos.top+(f_frame_height/2)-(pointer_height)+'px'
                        },pointer_speed,opts.easing,function(){
                            if(!animate_panels){
                                j_panels.hide().eq(mod_i).show();
                            }
                        });
                    }
                }
            }
            if(callback){
                $(document).oneTime(speed,'showItemCallback',callback);
            }
            current=i;
        };

        function extraWidth(el){
            if(!el){
                return 0;
            }
            if(el.length==0){
                return 0;
            }
            el=el.eq(0);
            var ew=0;ew+=getInt(el.css('paddingLeft'));
            ew+=getInt(el.css('paddingRight'));
            ew+=getInt(el.css('borderLeftWidth'));
            ew+=getInt(el.css('borderRightWidth'));
            return ew;
        };
        function extraHeight(el){
            if(!el){
                return 0;
            }
            if(el.length==0){
                return 0;
            }
            el=el.eq(0);
            var eh=0;
            eh+=getInt(el.css('paddingTop'));
            eh+=getInt(el.css('paddingBottom'));
            eh+=getInt(el.css('borderTopWidth'));
            eh+=getInt(el.css('borderBottomWidth'));
            return eh;
        };
        function showNextItem(){
            $(document).stopTime("transition");
            if(++iterator==j_frames.length){
                iterator=0;
            }
            showItem(iterator,opts.transition_speed);
            if(!paused&&opts.transition_interval>0){
                $(document).everyTime(opts.transition_interval,"transition",function(){
                    showNextItem();
                });
            }
        };
        function showPrevItem(){
            $(document).stopTime("transition");
            if(--iterator<0){
                iterator=item_count-1;
            }
            showItem(iterator,opts.transition_speed);
            if(!paused&&opts.transition_interval>0){
                $(document).everyTime(opts.transition_interval,"transition",function(){
                    showNextItem();
                });
            }
        };
        function getPos(el){
            if(!el)return{
                top:0,left:0
            };
            var left=0,top=0;
            var el_id=el.id;
            if(el.offsetParent){
                do{
                    left+=el.offsetLeft;top+=el.offsetTop;
                }while(el=el.offsetParent);
            }
            if(el_id==id){
                return{
                    'left':left,'top':top
                };
            }else{
                var gPos=getPos(j_gallery[0]);
                var gLeft=gPos.left;var gTop=gPos.top;
                return{
                    'left':left-gLeft,'top':top-gTop
                };
            }
        };
        function enableFrameClicking(){
            j_frames.each(function(i){
                if($('a',this).length==0){
                    $(this).click(function(){
                        if(iterator!=i){
                            $(document).stopTime("transition");
                            showItem(i,opts.transition_speed);
                            iterator=i;
                            if(!paused&&opts.transition_interval>0){
                                $(document).everyTime(opts.transition_interval,"transition",function(){
                                    showNextItem();
                                });
                            }
                        }
                    });
                }
            });
        };
        function buildPanels(){
            j_panels.each(function(i){
                if($('.panel-overlay',this).length>0){
                    $(this).append('<div class="overlay-background"></div>');
                }
            });
            /*
            if(opts.show_panel_nav){
                $('<img />').addClass('panel-nav-next').attr('src',theme_path+opts.nav_theme+'/next.'+opts.theme_format).appendTo(j_gallery).css({
                    position:'absolute',zIndex:'1100',cursor:'pointer',top:((opts.filmstrip_position=='top'?opts.frame_gap+wrapper_height:0)+(opts.panel_height-22)/2)+'px',right:((opts.filmstrip_position=='right'?opts.frame_gap+wrapper_width:0)+20)+'px',display:'none'
                }).click(showNextItem);
                $('<img />').addClass('panel-nav-prev').attr('src',theme_path+opts.nav_theme+'/prev.'+opts.theme_format).appendTo(j_gallery).css({
                    position:'absolute',zIndex:'1100',cursor:'pointer',top:((opts.filmstrip_position=='top'?opts.frame_gap+wrapper_height:0)+(opts.panel_height-22)/2)+'px',left:((opts.filmstrip_position=='left'?opts.frame_gap+wrapper_width:0)+20)+'px',display:'none'
                }).click(showPrevItem);
                $('<img />').addClass('nav-next-overlay').attr('src',theme_path+opts.nav_theme+'/panel-nav-next.'+opts.theme_format).appendTo(j_gallery).css({
                    position:'absolute',zIndex:'1099',top:((opts.filmstrip_position=='top'?opts.frame_gap+wrapper_height:0)+(opts.panel_height-22)/2)-10+'px',right:((opts.filmstrip_position=='right'?opts.frame_gap+wrapper_width:0)+10)+'px',display:'none',cursor:'pointer'
                }).click(showNextItem);
                $('<img />').addClass('nav-prev-overlay').attr('src',theme_path+opts.nav_theme+'/panel-nav-prev.'+opts.theme_format).appendTo(j_gallery).css({
                    position:'absolute',zIndex:'1099',top:((opts.filmstrip_position=='top'?opts.frame_gap+wrapper_height:0)+(opts.panel_height-22)/2)-10+'px',left:((opts.filmstrip_position=='left'?opts.frame_gap+wrapper_width:0)+10)+'px',display:'none',cursor:'pointer'
                }).click(showPrevItem);
            }*/
            j_panel_wrapper.css({
                width:opts.panel_width+'px',height:opts.panel_height+'px',position:'absolute',overflow:'hidden'
            });
            if(opts.show_filmstrip){
                switch(opts.filmstrip_position){
                    case'top':j_panel_wrapper.css({
                        top:wrapper_height+opts.frame_gap+'px'
                    });break;
                    case'left':j_panel_wrapper.css({
                        left:wrapper_width+opts.frame_gap+'px'
                    });break;
                    default:break;
                }
            }
            j_panels.each(function(i){
                $(this).css({
                    width:(opts.panel_width-extraWidth(j_panels))+'px',height:(opts.panel_height-extraHeight(j_panels))+'px',position:'absolute',top:0,left:0,display:'none'
                });
            });
            $('.panel-overlay',j_panels).css({
                position:'absolute',zIndex:'999',width:(opts.panel_width-extraWidth($('.panel-overlay',j_panels)))+'px',left:0
            });
            $('.overlay-background',j_panels).css({
                position:'absolute',zIndex:'998',width:opts.panel_width+'px',left:0,opacity:opts.overlay_opacity
            });
            if(opts.overlay_position=='top'){
                $('.panel-overlay',j_panels).css('top',0);
                $('.overlay-background',j_panels).css('top',0);
            }else{
                $('.panel-overlay',j_panels).css('bottom',0);
                $('.overlay-background',j_panels).css('bottom',0);
            }
            $('.panel iframe',j_panels).css({
                width:opts.panel_width+'px',height:opts.panel_height+'px',border:0
            });
            if(scale_panel_images){
                $('img',j_panels).each(function(i){
                    $(this).css({
                        height:panel_img_scale[i%item_count]*img_h[i%item_count],width:panel_img_scale[i%item_count]*img_w[i%item_count],position:'relative',top:(opts.panel_height-(panel_img_scale[i%item_count]*img_h[i%item_count]))/2+'px',left:(opts.panel_width-(panel_img_scale[i%item_count]*img_w[i%item_count]))/2+'px'
                    });
                });
            }
        };
        function buildFilmstrip(){
            j_filmstrip.wrap('<div class="strip_wrapper"></div>');
            if(opts.filmstrip_style=='scroll'&&slide_method=='strip'){
                j_frames.clone().appendTo(j_filmstrip);
                j_frames.clone().appendTo(j_filmstrip);
                j_frames=$('li',j_filmstrip);
            }
            if(opts.show_captions){
                j_frames.append('<div class="caption"></div>').each(function(i){
                    $(this).find('.caption').html($(this).find('img').attr('title'));
                });
            }
            j_filmstrip.css({
                listStyle:'none',margin:0,padding:0,width:strip_width+'px',position:'absolute',zIndex:'900',top:(filmstrip_orientation=='vertical'&&opts.filmstrip_style=='scroll'&&slide_method=='strip'?-((f_frame_height+opts.frame_gap)*iterator):0)+'px',left:(filmstrip_orientation=='horizontal'&&opts.filmstrip_style=='scroll'&&slide_method=='strip'?-((f_frame_width+opts.frame_gap)*iterator):0)+'px',height:strip_height+'px'
            });
            j_frames.css({
                "float": 'left',
                position: 'relative',
                height:f_frame_height+(opts.show_captions?f_caption_height:0)+'px',
                width:f_frame_width+'px',
                zIndex:'901',
                padding:0,
                cursor:'pointer',
                marginBottom:opts.frame_gap+'px',
                marginRight:opts.frame_gap+'px'
            });
            $('.img_wrap',j_frames).each(function(i){
                $(this).css({
                    height:Math.min(opts.frame_height,img_h[i%item_count]*frame_img_scale[i%item_count])+'px',width:Math.min(opts.frame_width,img_w[i%item_count]*frame_img_scale[i%item_count])+'px',position:'relative',top:(opts.show_captions&&opts.filmstrip_position=='top'?f_caption_height:0)+Math.max(0,(opts.frame_height-(frame_img_scale[i%item_count]*img_h[i%item_count]))/2)+'px',left:Math.max(0,(opts.frame_width-(frame_img_scale[i%item_count]*img_w[i%item_count]))/2)+'px',overflow:'hidden'
                });
            });
            $('img',j_frames).each(function(i){
                $(this).css({
                    opacity:opts.frame_opacity,height:img_h[i%item_count]*frame_img_scale[i%item_count]+'px',width:img_w[i%item_count]*frame_img_scale[i%item_count]+'px',position:'relative',top:Math.min(0,(opts.frame_height-(frame_img_scale[i%item_count]*img_h[i%item_count]))/2)+'px',left:Math.min(0,(opts.frame_width-(frame_img_scale[i%item_count]*img_w[i%item_count]))/2)+'px'
                }).mouseover(function(){
                    $(this).stop().animate({opacity:1},300);
                }).mouseout(function(){
                    if(!$(this).parent().parent().hasClass('current')){
                        $(this).stop().animate({opacity:opts.frame_opacity},300);
                    }
                });
            });
            $('.strip_wrapper',j_gallery).css({
                position:'absolute',overflow:'hidden',margin:'25px 0'
            });
            if(filmstrip_orientation=='horizontal'){
                $('.strip_wrapper',j_gallery).css({
                    top:opts.show_panels?opts.filmstrip_position=='top'?0:opts.panel_height+opts.frame_gap+'px':0,left:((gallery_width-wrapper_width)/2)+'px',width:wrapper_width+'px',height:wrapper_height+'px'
                });
            }else{
                $('.strip_wrapper',j_gallery).css({
                    left:opts.show_panels?opts.filmstrip_position=='left'?0:opts.panel_width+opts.frame_gap+'px':0,top:0,width:wrapper_width+'px',height:wrapper_height+'px'
                });
            }
            $('.caption',j_gallery).css({
                position:'absolute',top:(opts.filmstrip_position=='bottom'?f_frame_height:0)+'px',left:0,margin:0,width:f_caption_width+'px',height:frame_caption_size+'px',overflow:'hidden',lineHeight:frame_caption_size+'px'
            });
            var pointer=$('<div></div>');
            pointer.addClass('pointer').appendTo(j_gallery).css({
                position:'absolute',zIndex:'1000',width:0,fontSize:0,lineHeight:0,borderTopWidth:pointer_height+'px',borderRightWidth:(pointer_width/2)+'px',borderBottomWidth:pointer_height+'px',borderLeftWidth:(pointer_width/2)+'px',borderStyle:'solid'
            });
            var transColor=$.browser.msie&&$.browser.version.substr(0,1)=='6'?'pink':'transparent';
            if(!opts.show_panels){
                pointer.css('borderColor',transColor);
            }
            switch(opts.filmstrip_position){
                case'top':pointer.css({
                    top:wrapper_height+'px',left:((gallery_width-wrapper_width)/2)+(slide_method=='strip'?0:((f_frame_width+opts.frame_gap)*iterator))+((f_frame_width/2)-(pointer_width/2))+'px',borderBottomColor:transColor,borderRightColor:transColor,borderLeftColor:transColor
                });break;
                case'bottom':pointer.css({
                    bottom:wrapper_height+'px',left:((gallery_width-wrapper_width)/2)+(slide_method=='strip'?0:((f_frame_width+opts.frame_gap)*iterator))+((f_frame_width/2)-(pointer_width/2))+'px',borderTopColor:transColor,borderRightColor:transColor,borderLeftColor:transColor
                });break;
                case'left':pointer.css({
                    left:wrapper_width+'px',top:(f_frame_height/2)-(pointer_height)+(slide_method=='strip'?0:((f_frame_height+opts.frame_gap)*iterator))+'px',borderBottomColor:transColor,borderRightColor:transColor,borderTopColor:transColor
                });break;
                case'right':pointer.css({
                    right:wrapper_width+'px',top:(f_frame_height/2)-(pointer_height)+(slide_method=='strip'?0:((f_frame_height+opts.frame_gap)*iterator))+'px',borderBottomColor:transColor,borderLeftColor:transColor,borderTopColor:transColor
                });break;
            }
            j_pointer=$('.pointer',j_gallery);
            if(opts.show_filmstrip_nav){
                var navNext=$('<img />');navNext.addClass('nav-next').attr('src',theme_path+opts.nav_theme+'/next.'+opts.theme_format).appendTo(j_gallery).css({position:'absolute',cursor:'pointer'}).click(showNextItem);
                var navPrev=$('<img />');navPrev.addClass('nav-prev').attr('src',theme_path+opts.nav_theme+'/prev.'+opts.theme_format).appendTo(j_gallery).css({position:'absolute',cursor:'pointer'}).click(showPrevItem);
                if(filmstrip_orientation=='horizontal'){
                    navNext.css({
                        top:(opts.show_panels?(opts.filmstrip_position=='top'?(opts.show_captions?f_caption_height:0):opts.panel_height+opts.frame_gap):0)+((f_frame_height-22)/2)+'px',
                        right:((gallery_width)/2)-(wrapper_width/2)-opts.frame_gap-22+'px'
                    });
                    navPrev.css({
                        top:(opts.show_panels?(opts.filmstrip_position=='top'?(opts.show_captions?f_caption_height:0):opts.panel_height+opts.frame_gap):0)+((f_frame_height-22)/2)+'px',
                        left:((gallery_width)/2)-(wrapper_width/2)-opts.frame_gap-22+'px'
                    });
                }else{
                    navNext.css({
                        right:'0px',
                        bottom:'0px'
                    });
                    navPrev.css({
                        right:'0px',
                        top:'0px'
                    });
                }
            }
        };
        function mouseIsOverGallery(x,y){
            var pos=getPos(j_gallery[0]);
            var top=pos.top;
            var left=pos.left;return x>left&&x<left+j_gallery.outerWidth()&&y>top&&y<top+j_gallery.outerHeight();
        };
        function mouseIsOverPanel(x,y){
            var pos=getPos($('#'+id+' .panel_wrap')[0]);
            var gPos=getPos(j_gallery[0]);
            var top=pos.top+gPos.top;
            var left=pos.left+gPos.left;return x>left&&x<left+j_panels.outerWidth()&&y>top&&y<top+j_panels.outerHeight();
        };
        function getInt(i){
            i=parseInt(i,10);
            if(isNaN(i)){i=0;}
            return i;
        };
        function buildGallery(){
            var gallery_images=opts.show_filmstrip?$('img',j_frames):$('img',j_panels);
            gallery_images.each(function(i){
                img_h[i]=this.height;
                img_w[i]=this.width;
                if(opts.frame_scale=='nocrop'){
                    frame_img_scale[i]=Math.min(opts.frame_height/img_h[i],opts.frame_width/img_w[i]);
                }else{
                    frame_img_scale[i]=Math.max(opts.frame_height/img_h[i],opts.frame_width/img_w[i]);
                }
                if(opts.panel_scale=='nocrop'){
                    panel_img_scale[i]=Math.min(opts.panel_height/img_h[i],opts.panel_width/img_w[i]);
                }else{
                    panel_img_scale[i]=Math.max(opts.panel_height/img_h[i],opts.panel_width/img_w[i]);
                }
            });

            j_gallery.css({
                position:'relative',
                width:gallery_width+'px',
                height:gallery_height+'px'
            });
            if(opts.show_filmstrip) {
                buildFilmstrip();
                enableFrameClicking();
            }
            if(opts.show_panels){
                buildPanels();
            }
            /*マウスオーバー時の切り替えボタン*/
            /*if(opts.pause_on_hover||opts.show_panel_nav){
                $(document).mousemove(function(e){
                    if(opts.pause_on_hover){
                        if(mouseIsOverGallery(e.pageX,e.pageY)&&!paused){
                            $(document).oneTime(500,"animation_pause",function(){
                                $(document).stopTime("transition");
                                paused=true;
                            });
                        }else{
                            $(document).stopTime("animation_pause");
                            if(paused&&opts.transition_interval>0){
                                $(document).everyTime(opts.transition_interval,"transition",function(){
                                    showNextItem();
                                });
                                paused=false;
                            }
                        }
                    }

                    if(opts.show_panel_nav){
                        if(mouseIsOverPanel(e.pageX,e.pageY)&&!panel_nav_displayed){
                            $('.nav-next-overlay, .panel-nav-next, .nav-prev-overlay, .panel-nav-prev',j_gallery).show();
                            panel_nav_displayed=true;
                        }else if(!mouseIsOverPanel(e.pageX,e.pageY)&&panel_nav_displayed){
                            $('.nav-next-overlay, .panel-nav-next, .nav-prev-overlay, .panel-nav-prev',j_gallery).hide();
                            panel_nav_displayed=false;
                        }
                    }
                });
            }*/
            j_filmstrip.css('visibility','visible');
            j_gallery.css('visibility','visible');
            showItem(iterator,10,function(){
                $('.loader',j_gallery).fadeOut('1000',function(){
                    if(item_count>1&&opts.transition_interval>0){
                        $(document).everyTime(opts.transition_interval,"transition",function(){
                            showNextItem();
                        });
                    }
                });
            });
        };

        return this.each(function(){
            var _t=$(this);
            _t.css('visibility','hidden');
            gallery_images=$('img',_t);
            image_count=gallery_images.length;
            current=opts.start_frame-1;
            _t.wrap("<div></div>");
            j_gallery=_t.parent();
            j_gallery.css('visibility','hidden').attr('id',_t.attr('id')).addClass('gallery');
            _t.removeAttr('id').addClass('filmstrip');
            $(document).stopTime("transition");
            $(document).stopTime("animation_pause");
            id=j_gallery.attr('id');
            scale_panel_images=$('.panel-content',j_gallery).length==0;
            if(opts.filmstrip_style=='show all')opts.show_filmstrip_nav=false;
            animate_panels=(opts.panel_animation!='none');
            filmstrip_orientation=(opts.filmstrip_position=='top'||opts.filmstrip_position=='bottom'?'horizontal':'vertical');
            if(filmstrip_orientation=='vertical'){
                opts.show_captions=false;
            }
            if(filmstrip_orientation=='horizontal'&&opts.pointer_size>opts.frame_width/2){
                opts.pointer_size=opts.frame_width/2;
            }
            if(filmstrip_orientation=='vertical'&&opts.pointer_size>opts.frame_height/2){
                opts.pointer_size=opts.frame_height/2;
            }
            $('script').each(function(i){
                var s=$(this);
                if(s.attr('src')&&s.attr('src').match(/jquery\.galleryview/)){
                    loader_path=s.attr('src').split('jquery.galleryview')[0];
                    theme_path=s.attr('src').split('jquery.galleryview')[0];
                    href=s.attr('src').split('jquery.galleryview')[0]
                }
            });
            j_filmstrip=$('.filmstrip',j_gallery);
            j_frames=$('li',j_filmstrip);
            j_frames.addClass('frame');
            j_panel_wrapper=$('<div>');
            j_panel_wrapper.addClass('panel_wrap').prependTo(j_gallery);
            if(opts.show_panels){
                for(i=j_frames.length-1;i>=0;i--){
                    if(j_frames.eq(i).find('.panel-content').length>0){
                        j_frames.eq(i).find('.panel-content').remove().prependTo(j_panel_wrapper).addClass('panel');
                    }else{
                        p=$('<div>');
                        p.addClass('panel');
                        a=$('<a>');
                        a.attr('href',j_frames.eq(i).find('a').eq(0).attr('href'));
                        im=$('<img />');
                        a.appendTo(p);
                        im.attr('src',j_frames.eq(i).find('img').eq(0).attr('src')).appendTo(a);
                        p.prependTo(j_panel_wrapper);
                        j_frames.eq(i).find('.panel-overlay').remove().appendTo(p);
                    }
                }
            }else{
                $('.panel-overlay',j_frames).remove();
                $('.panel-content',j_frames).remove();
            }
            if(!opts.show_filmstrip){
                j_filmstrip.remove();
            }else{
                j_frames.each(function(i){
                    if( $(this).find('a').length > 0 ) {
                        var text=$('a', $(this)).html();
                        $(this).empty().append(text).wrap('<div class="img_wrap"></div>');
                        //$(this).find('a').wrap('<div class="img_wrap"></div>'); //元
                    }else{
                        $(this).find('img').wrap('<div class="img_wrap"></div>');
                    }
                });
                j_frame_img_wrappers=$('.img_wrap',j_frames);
            }
            j_panels=$('.panel',j_gallery);
            if(!opts.show_panels){
                opts.panel_height=0;
                opts.panel_width=0;
            }
            $('<div class="caption"></div>').appendTo(j_frames);
            f_frame_width=opts.frame_width+extraWidth(j_frame_img_wrappers);
            f_frame_height=opts.frame_height+extraHeight(j_frame_img_wrappers);
            frame_caption_size=getInt($('.caption',j_gallery).css('height'));
            f_caption_width=f_frame_width-extraWidth($('.caption',j_gallery));
            f_caption_height=frame_caption_size+extraHeight($('.caption',j_gallery));
            $('.caption',j_gallery).remove();
            item_count=opts.show_panels?j_panels.length:j_frames.length;
            if(filmstrip_orientation=='horizontal'){
                strip_size=opts.show_panels?Math.floor((opts.panel_width+opts.frame_gap-(opts.filmstrip_style=='show all'?0:(opts.frame_gap+22)*2))/(f_frame_width+opts.frame_gap)):Math.min(item_count,opts.filmstrip_size);
            }else{
                strip_size=opts.show_panels?Math.floor((opts.panel_height+opts.frame_gap-(opts.filmstrip_style=='show all'?0:opts.frame_gap+22))/(f_frame_height+opts.frame_gap)):Math.min(item_count,opts.filmstrip_size);
            }
            if(strip_size>=item_count){
                slide_method='pointer';
                strip_size=item_count;
            }else{
                slide_method='strip';
            }
            if(Math.ceil(item_count/strip_size)>1){
                opts.pointer_size=0;
            }
            pointer_height=opts.pointer_size;
            pointer_width=opts.pointer_size*2;
            iterator=opts.start_frame-1;
            if(opts.filmstrip_style=='scroll'&&strip_size<item_count){
                iterator+=item_count;
            }
            j_filmstrip.css('margin',0);
            if(filmstrip_orientation=='horizontal'){
                if(opts.filmstrip_style=='show all'||(opts.filmstrip_style=='scroll'&&slide_method=='pointer')){
                    strip_width=(f_frame_width*strip_size)+(opts.frame_gap*(strip_size));
                }else{
                    strip_width=(f_frame_width*item_count*3)+(opts.frame_gap*((item_count*3)));
                }
            }else{
                if(opts.filmstrip_style=='show all'){
                    strip_width=(f_frame_width*Math.ceil(item_count/strip_size))+(opts.frame_gap*(Math.ceil(item_count/strip_size)));
                }else{
                    strip_width=(f_frame_width);
                }
            }
            if(filmstrip_orientation=='horizontal'){
                if(opts.filmstrip_style=='show all'){
                    strip_height=((f_frame_height+(opts.show_captions?f_caption_height:0))*Math.ceil(item_count/strip_size))+(opts.frame_gap*(Math.ceil(item_count/strip_size)-1));
                }else{
                    strip_height=(f_frame_height+(opts.show_captions?f_caption_height:0));
                }
            }else{
                if(opts.filmstrip_style=='show all'||(opts.filmstrip_style=='scroll'&&slide_method=='pointer')){
                    strip_height=((f_frame_height*strip_size)+opts.frame_gap*(strip_size-1));
                }else{
                    strip_height=(f_frame_height*item_count*3)+(opts.frame_gap*((item_count*3)-1));
                }
            }
            if(filmstrip_orientation=='horizontal'){
                wrapper_width=((strip_size*f_frame_width)+((strip_size-1)*opts.frame_gap));
                if(opts.filmstrip_style=='show all'){
                    wrapper_height=((f_frame_height+(opts.show_captions?f_caption_height:0))*Math.ceil(item_count/strip_size))+(opts.frame_gap*(Math.ceil(item_count/strip_size)-1));
                }else{
                    wrapper_height=(f_frame_height+(opts.show_captions?f_caption_height:0));
                }
            }else{
                wrapper_height=((strip_size*f_frame_height)+((strip_size-1)*opts.frame_gap));
                if(opts.filmstrip_style=='show all'){
                    wrapper_width=(f_frame_width*Math.ceil(item_count/strip_size))+(opts.frame_gap*(Math.ceil(item_count/strip_size)-1));
                }else{
                    wrapper_width=f_frame_width;
                }
            }
            j_gallery.css('padding',0);
            if(filmstrip_orientation=='horizontal'){
                gallery_width=opts.show_panels?opts.panel_width:wrapper_width+44+(opts.frame_gap*2);
                gallery_height=(opts.show_panels?opts.panel_height+(opts.show_filmstrip?opts.frame_gap:0):0)+(opts.show_filmstrip?wrapper_height:0);
            }else{
                gallery_height=opts.show_panels?opts.panel_height:wrapper_height+22;
                gallery_width=(opts.show_panels?opts.panel_width+(opts.show_filmstrip?opts.frame_gap:0):0)+(opts.show_filmstrip?wrapper_width:0);
            }
            galleryPos=getPos(j_gallery[0]);
            $('<div>').addClass('loader').css({
                position:'absolute',zIndex:'32666',opacity:1,top:0,left:0,width:gallery_width+'px',height:gallery_height+'px'
            }).appendTo(j_gallery);
            if(opts.transition_speed>opts.transition_interval&&opts.transition_interval>0){
                opts.transition_speed=opts.transition_interval;
            }
            pointer_speed=opts.animate_pointer?opts.transition_speed:0;
            if(!window_loaded){
//                gallery_images.each(function(i){
//                    if($(this).attr('complete')){
//                        loaded_images++;
//alert('yonda!'+loaded_images);
//                        if(loaded_images==image_count){
//                            buildGallery();
//                            window_loaded;
//                        }
//                    }else{
//                        $(this).load(function(){
//                            loaded_images++;
//alert('yonda!!'+loaded_images);
//                            if(loaded_images==image_count){
//                                buildGallery();
//                                window_loaded;
//                            }
//                        });
//                    }
//                });
                $(document).everyTime(100, 'LoadEventGalleryView', function(){
                    if ( window_loaded ) {
                        buildGallery();
                        $(document).stopTime('LoadEventGalleryView');
                    }
                });
            }else{
                buildGallery();
            }
        });
    };

    $.fn.galleryView.defaults={
        transition_speed:800,
        transition_interval:4000,
        nav_theme:'images',
        theme_format:'jpg',
        easing:'swing',
        pause_on_hover:false,
        show_panels:true,
        panel_width:600,
        panel_height:400,
        panel_animation:'crossfade',
        overlay_opacity:0.7,
        overlay_position:'bottom',
        panel_scale:'crop',
        show_panel_nav:true,
        show_filmstrip:true,
        frame_width:60,
        frame_height:40,
        start_frame:1,
        filmstrip_size:3,
        frame_opacity:0.3,
        filmstrip_style:'scroll',
        filmstrip_position:'bottom',
        show_filmstrip_nav:true,
        frame_scale:'crop',
        frame_gap:0,
        show_captions:false,
        pointer_size:8,
        animate_pointer:true
    };
})(jQuery);