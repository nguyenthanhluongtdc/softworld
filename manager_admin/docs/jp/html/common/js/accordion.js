//Accordion
(function($){

	//accordion29表示/非表示 の切り替え
	$(function(){

		//オブジェクトを保存
		var accordionItem=$('#accordion-29');
		//一旦全部消す
		accordionItem.find('div').hide();

		//active要素を指定して開く
		var no=0;
		//accordionItem.find('h3').eq(no).addClass('active').next('div').show();

		//click-action
		accordionItem.find('h3').click(function () {

			//active切り替え
			$(this).toggleClass('active');
			//表示非表示
			$(this).next('div').toggle();

		});

		//hover-toggle
		accordionItem.find('h3').hover(function () {

			//toggle hoveredクラス
			$(this).toggleClass('hovered');

		});
	});

})(jQuery);

//Accordion
(function($){

	//accordion30
	$(function(){

		//オブジェクトを保存
		var accordionItem=$('#accordion-30');
		//一旦全部消す
		$('#accordion-30').find('div').hide();

		//active要素を指定して開く
		var no=0;
		//accordionItem.find('h3').eq(no).addClass('active').next('div').show();

		//click-action
		accordionItem.find('h3').click(function () {

			//active切り替え
			$(this).toggleClass('active');

			//slideToggle
			$(this).next('div').slideToggle('slow');

		});

		//hover-toggle
		accordionItem.find('h3').hover(function () {

			//toggle hoveredクラス
			$(this).toggleClass('hovered');

		});
	});

})(jQuery);


//Accordion
(function($){

	//accordion31
	$(function(){

		//オブジェクトを保存
		var accordionItem=$('#accordion-31');
		//一旦全部消す
		accordionItem.find('div').hide();

		//active要素を指定して開く
		var no=0;
		//accordionItem.find('h3').eq(no).addClass('active').next('div').show();

		//click-action
		accordionItem.find('h3').click(function () {

			//slide
			$(this).next('div').slideToggle('slow')
			.siblings('div:visible').slideUp('slow');
			//activeクラス切り替え
			$(this).toggleClass('active');
			$(this).siblings('h3').removeClass('active');

		});

		//hover-toggle
		accordionItem.find('h3').hover(function () {

			//toggle hoveredクラス
			$(this).toggleClass('hovered');

		});
	});

})(jQuery);


//Accordion
(function($){

	//accordion32
	$(function(){

		//オブジェクトを保存
		var accordionItem=$('#accordion-32');
		//一旦全部消す
		accordionItem.find('div').hide();

		//active要素を指定して開く
		var no=0;
		//accordionItem.find('h3').eq(no).addClass('active').next('div').show();

		//click-action
		accordionItem.find('h3').click(function () {

			//active切り替え
			$(this).toggleClass('active');

			//DL要素オブジェクトを代入
			var hitItem = $(this).next();
			//開いている要素
			var openItem = hitItem.siblings('div:visible');

			//開いている要素があれば最初に閉じる
			if (openItem.length) {
				openItem.prev().removeClass('active');
				openItem.slideUp('fast',function() {
					//其の後開く
					hitItem.slideToggle('normal');
				});
			} else {
				//開いている要素が無ければ
				hitItem.slideToggle('normal');
			}

		});

		//hover-toggle
		accordionItem.find('h3').hover(function () {

			//toggle hoveredクラス
			$(this).toggleClass('hovered');

		});
	});

})(jQuery);