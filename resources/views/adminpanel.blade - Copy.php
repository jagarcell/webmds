@extends('layouts.master')
@section('header')
<title id="Home_Tab">
Administration Panel
</title>
@endsection

@section('scripts')
<script type="text/javascript" src="/js/products.js"></script>
@endsection

@section('main')
<div class="main">
	<div class="content">
		<div>
            <div class="section group">
				<div style="width: 45%; height: 20px; float: left; margin-left: 0px;">
					<!-- USER PROVIDED LANGUAGES FOR TRANSLTION -->
					<textarea hidden="" id="translangkey">{{$translang}}</textarea>
					<textarea hidden="" id="baselangkey">{{$baselang}}</textarea>
					<!-- LANGUAGE TO TRANSLATE SELECTOR -->
					<select name="transLangDdl" id="translangSelect" style="width: 100%">
						<!-- CHECKING OF USER PROVIDED LANGUAGE TO TRANSLATE -->
						@foreach($languages as $key => $language)
						@if($key == $translang)
						<option value="{{$language->lang}}" selected="">{{$language->description}}</option>
						@else
						<option value="{{$language->lang}}">{{$language->description}}</option>
						@endif
						@endforeach
					</select>
				</div>
				<!-- TARGET TRANSLATION LANGUAGE SELECTOR -->
				<div style="width: 45%; height: 20px; float: right; margin-right: 0px;">
					<select name="baseLangDdl" id="baselangSelect" style="width: 100%">
						@foreach($languages as $key => $language)
						<!-- CHECKING OF USER PROVIDED TARGET LANGUAGE -->
						@if($key == $baselang)
						<option value="{{$language->lang}}" selected="" id="option_{{$key}}">{{$language->description}}</option>
						@else
						<option value="{{$language->lang}}">{{$language->description}}</option>
						@endif
						@endforeach
					</select>
				</div>
				<!-- GROUPS DROPDOWN LIST SELECTOR -->
				<div style="width: 45%; height: 2em; float: left; margin-left: 0px; margin-top: 20px;">
					<select id="groupsddl" style="width: 100%;">
							@foreach($groups as $key => $group)
							<option style="width: 20%; overflow-wrap: all;" id="{{$group->id}}" class="groupoption_{{$key}}">
								{{$group->groupsdescriptions[0]->description}}
							</option>
							@endforeach
					</select>
				</div>
				<!-- FOR TO SAVE THE TRANSLATED GROUPS -->
				<form action="/grouptranslationupdate" method="post">
					{{ csrf_field() }}
					<input name="baseLang" id="saveLang" type="" value="{{$baselang}}" hidden="">
					@foreach($translatedgroups as $key => $translaledgroup)
					<input name="groupchanged[]" id="groupchanged_{{$translaledgroup->id}}" type="" value="" class="translatedgroupchanged_{{$key}}" hidden>
					<input name="groupsdescriptionsid[]" type="" value="{{$translaledgroup->groupsdescriptions[0]->id}}" class="translatedgroupsdescriptionsid_{{$key}}" hidden="">
					<input name="groupsid[]" type="" value="{{$translaledgroup->id}}" class="translatedgroupsid_{{$key}}" hidden="">
					<input name="groups[]" id="original_text_{{$translaledgroup->id}}" type="text" value="{{$translaledgroup->groupsdescriptions[0]->description}}" class="original_text_{{$key}}" hidden="">
					@endforeach
					<div id="groupsdiv" style="width: 45%; float: right; margin-right: 0px; margin-top: 20px;">
						<textarea spellcheck="FALSE" id="original_text" style="width: 100%; height: 20px; text-transform: uppercase;"></textarea>
					</div>
					<div style="float: left;width: 100%; margin-left: 0px;">
						<!-- PRODUCTS TRANSLATION SECTION -->
						<div style="float: left; margin-left: 0px; width: 45%; height: 4em; margin-top: 20px; overflow: auto;">
							<!-- PRODUCTS TO TRANSLATE DROPDOWN LIST -->
							<select id="productstotranslateddl" style="width: 100%;">
								@for($i = 0; $i < $maxGroupProductsCount; $i++)
								<!-- THE ID IS ASIGNED FROM JQUERY -->
								<option id="" class="product_{{$i}} product">
								</option>
								@endfor
								@for($i = 0; $i < $maxGroupProductsCount; $i++)
								<input type="" name="productchanged[]" class="productchanged_{{$i}}" id="" value="" hidden="">
								<input type="" name="productchangedid[]" class="productchangedid_{{$i}}" id="" value="" hidden="">
								<input type="" name="translatedproduct[]" class="translatedproduct_{{$i}}" hidden="">
								@endfor
							</select>
						</div>
						<div style="width: 45%; float: right; margin-right: 0px; margin-top: 20px;">
							<textarea spellcheck="false" style="width: 100%; height: 20px;" id="translated_product_text">
							</textarea>
						</div>
					</div>
					<!-- SAVE BUTTON -->
					<div style="width: 24%; height: 100%;margin-left: 38%; margin-top: 20px; float: left; text-align: center;">
						<input style="width: 100%;" type="submit" name="submitbtn" value="@lang('adminpanel.save')">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('#translangSelect').on('change', translationLanguageChanged )
		$('#baselangSelect').on('change', baseLanguageChanged )
		$('#groupsddl').on('change', groupsddlchange )
		$('#original_text').on('change', originalTextChange)
		$('#productstotranslateddl').on('change', productstotranslateddlchanged)
		$('#translated_product_text').on('change', translatedproducttextchanged)

		var htmlElement = document.getElementById('groupsddl')
		var id = htmlElement[htmlElement.selectedIndex].id
		$('#original_text').val($('#original_text_' + id).val())
		$('#saveLang').val($('#baselangSelect').val())

		initializeproducts();
	});

	function translatedproducttextchanged(event)
	{
		var productstotranslateddlselected = $('#productstotranslateddl').prop('selectedIndex')
		$('.translatedproduct_' + productstotranslateddlselected).val($('#translated_product_text').prop('value'))
		$('.productchanged_' + productstotranslateddlselected).prop('value', 'Y')
		alert($('.productchanged_' + productstotranslateddlselected).prop('value'))

	}

	function productstotranslateddlchanged(event)
	{

		var producttotranslate = $(this).val();
		
		$('#translated_product_text').prop('value', $('.translatedproduct_' + $(this).prop('selectedIndex')).val())
	}

	function baseLanguageChanged(event)
	{
		$.get('/groups',
			{lang:$(this).val()},
			function(data, status){
				var groups = JSON.parse(data)
				for (var i = 0; i < groups.length; i++) {
					$('.translatedgroupchanged_' + i).val('')
					$('.translatedgroupsdescriptionsid_' + i).val(groups[i]['groupsdescriptions'][0]['id'])
					$('.translatedgroupsid_' + i).val(groups[i]['id'])
					$('.original_text_' + i).val(groups[i]['groupsdescriptions'][0]['description'])
				}
				$('#original_text').val(groups[$('#groupsddl').prop('selectedIndex')]['groupsdescriptions'][0]['description'])
			})
		$('#saveLang').val($(this).val())
	}

	function originalTextChange(event)
	{
		var groupsddl = document.getElementById('groupsddl')
		var textarea = document.getElementById('original_text_' + groupsddl[groupsddl.selectedIndex].id)
		textarea.value = $('#original_text').val().toUpperCase()
		var groupchanged = document.getElementById('groupchanged_' + groupsddl[groupsddl.selectedIndex].id)
		groupchanged.value = "Y"
	}

	function groupsddlchange(event)
	{
		var htmlElement = event.target;
		var id = htmlElement[htmlElement.selectedIndex].id
		$('#original_text').val($('#original_text_' + id).val())

		$('.product').prop('hidden', true)

		var initialGroup = $('.groupoption_' + $(this).prop('selectedIndex')).prop('id')

		$.get('/productsingroup',
			{lang:$('#translangSelect').val(),
			id:initialGroup},
			function(data, status){
				var products = JSON.parse(data)
				for (var i = 0; i < products.length; i++) {
					$('.product_' + i).prop('id', products[i]['id']);
					$('.product_' + i).prop('text',products[i]['productsdescriptions'][0]['description'])
					$('.product_' + i).prop('hidden', false)
				}
			}
		)

		initializeproducts();
	}

	function initializeproducts()
	{
		$('.product').prop('hidden', true)

		var initialGroup = $('.groupoption_'+ $('#groupsddl').prop('selectedIndex')).prop('id')

		$.get('/productsingroup',
			{lang:$('#translangSelect').val(),
			id:initialGroup},
			function(data, status){
				var products = JSON.parse(data)
				for (var i = 0; i < products.length; i++) {
					$('.product_' + i).prop('id', products[i]['id']);
					$('.product_' + i).prop('text',products[i]['productsdescriptions'][0]['description'])
					$('.product_' + i).prop('hidden', false)
				}
			}
		)

		$.get('/productsingroup',
			{lang:$('#baselangSelect').val(),
			id:initialGroup},
			function(data, status){
				var products = JSON.parse(data)
				for (var i = 0; i < products.length; i++) {
					$('.productchanged_' + i).prop('value', '')
					$('.productchangedid_' + i).prop('value', products[i]['id'])
					$('.translatedproduct_' + i).prop('id', products[i]['id'])
					$('.translatedproduct_' + i).prop('value',products[i]['productsdescriptions'][0]['description'])
					$("#translated_product_text").prop('value', $(".translatedproduct_0").val())
				}
			}
		)
	}

	function groupTextFocus(textElement)
	{
		var id = textElement.id;
		document.getElementById('original_text').value = document.getElementById('original_text_' + id).value
	}

	function translationLanguageChanged(event)
	{

		$.get('/groups',
			{lang:$(this).val()},
			function(data, status){
				var groups = JSON.parse(data)
				for (var i = 0; i < groups.length; i++) {
					$('.groupoption_' + i).attr('id', groups[i]['id'])
					$('.groupoption_' + i).text(groups[i]['groupsdescriptions'][0]['description'])
				}
			});

	}
</script>
@endsection