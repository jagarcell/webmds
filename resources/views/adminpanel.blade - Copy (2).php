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
					<!-- LANGUAGE TO TRANSLATE SELECTOR -->
					<select id="fromLangSelect" style="width: 100%">
						<!-- CHECKING OF USER PROVIDED LANGUAGE TO TRANSLATE -->
						@foreach($languages as $key => $language)
						@if($key == $fromLangKey)
						<option value="{{$language->lang}}" selected="">{{$language->description}}</option>
						@else
						<option value="{{$language->lang}}">{{$language->description}}</option>
						@endif
						@endforeach
					</select>
				</div>
				<!-- TARGET TRANSLATION LANGUAGE SELECTOR -->
				<div style="width: 45%; height: 20px; float: right; margin-right: 0px;">
					<select id="toLangSelect" style="width: 100%">
						@foreach($languages as $key => $language)
						<!-- CHECKING OF USER PROVIDED TARGET LANGUAGE -->
						@if($key == $toLangKey)
						<option value="{{$language->lang}}" selected="">{{$language->description}}</option>
						@else
						<option value="{{$language->lang}}">{{$language->description}}</option>
						@endif
						@endforeach
					</select>
				</div>
				<!-- GROUPS DROPDOWN LIST SELECTOR -->
				<div style="width: 45%; height: 2em; float: left; margin-left: 0px; margin-top: 20px;">
					<select id="fromGroupSelect" style="width: 100%;">
						@foreach($groups as $key => $group)
						@foreach($group->allgroupsdescriptions as $key1 => $groupsdescriptions)
						<option value="{{$group->groupid}}" class="fromGroupSelect_{{$groupsdescriptions->lang}} fromGroupSelect" hidden style="width: 20%; overflow-wrap: all;">
							{{$groupsdescriptions->description}}
						</option>
						@endforeach
						@endforeach
					</select>
				</div>

				<div id="groupsdiv" style="width: 45%; float: right; margin-right: 0px; margin-top: 20px;">
					<textarea spellcheck="FALSE" id="toGroupText" style="width: 100%; height: 20px; text-transform: uppercase;">
					</textarea>
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
						</select>
					</div>
					<div style="width: 45%; float: right; margin-right: 0px; margin-top: 20px;">
						<textarea spellcheck="false" id="translated_product_text" style="width: 100%; height: 20px;">
						</textarea>
					</div>
				</div>
				<!-- FOR TO SAVE THE TRANSLATED GROUPS -->
				<form action="/grouptranslationupdate" method="post">
					{{ csrf_field() }}

					@foreach($groups as $key => $group)
					@foreach($group->allgroupsdescriptions as $key1 => $groupsdescriptions)
					<input name="toGroupChanged[]" id="toGroupChanged_{{$groupsdescriptions->id}}" class="toGroupChanged_{{$group->groupid}}_{{$groupsdescriptions->lang}}" value="" hidden="">
					<input name="toGroupsDescriptionsId[]" value="{{$groupsdescriptions->id}}" hidden="">
					<input name="toGroups[]" id="toGroupText_{{$groupsdescriptions->id}}" value="{{$groupsdescriptions->description}}" class="toGroupsDescriptionsText_{{$group->groupid}}_{{$groupsdescriptions->lang}}"  hidden="">

					@endforeach
					@endforeach

					@for($i = 0; $i < $maxGroupProductsCount; $i++)
					<input name="productchanged[]" class="productchanged_{{$i}}" id="" value="" hidden="">
					<input name="productchangedid[]" class="productchangedid_{{$i}}" id="" value="" hidden="">
					<input name="translatedproduct[]" class="translatedproduct_{{$i}}" hidden="">
					@endfor
					<!-- SAVE BUTTON -->
					<div style="width: 24%; height: 100%;margin-left: 38%; margin-top: 20px; float: left; text-align: center;">
						<input name="submitbtn" type="submit" value="@lang('adminpanel.save')" style="width: 100%;">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function()
	{
		$('#fromLangSelect').on('change', fromLangSelectChanged )
		$('#toLangSelect').on('change', toLangSelectChanged )
		$('#fromGroupSelect').on('change', fromGroupSelectChange )
		$('#toGroupText').on('change', toGroupTextChange)
		$('#productstotranslateddl').on('change', productstotranslateddlchanged)
		$('#translated_product_text').on('change', translatedproducttextchanged)

		var htmlElement = document.getElementById('fromGroupSelect')
		var id = htmlElement[htmlElement.selectedIndex].id
		$('#original_text').val($('#original_text_' + id).val())
		$('#saveLang').val($('#toLangSelect').val())

		initializeGroups();

		initializeproducts();
	});

	function fromLangSelectChanged(event)
	{
		initializeGroups();
	}

	function initializeGroups()
	{
		$(".fromGroupSelect").prop('hidden', true)
		$(".fromGroupSelect_" + $("#fromLangSelect").val()).prop('hidden', false)

		$("#fromGroupSelect").prop('selectedIndex', $("#fromLangSelect").prop('selectedIndex'))
		$("#toGroupText").val($(".toGroupsDescriptionsText_" + $("#fromGroupSelect").val() + '_'
		 + $('#toLangSelect').val()).val())
	}

	function translatedproducttextchanged(event)
	{
		var productstotranslateddlselected = $('#productstotranslateddl').prop('selectedIndex')
		$('.translatedproduct_' + productstotranslateddlselected).val($('#translated_product_text').prop('value'))
		$('.productchanged_' + productstotranslateddlselected).prop('value', 'Y')
	}

	function productstotranslateddlchanged(event)
	{

		var producttotranslate = $(this).val();
		
		$('#translated_product_text').prop('value', $('.translatedproduct_' + $(this).prop('selectedIndex')).val())
	}

	function toLangSelectChanged(event)
	{
		initializeGroups();
	}

	function toGroupTextChange(event)
	{
		$(".toGroupsDescriptionsText_" + $("#fromGroupSelect").val() + '_' + $('#toLangSelect').val()).val($("#toGroupText").val())
		$(".toGroupChanged_" + $("#fromGroupSelect").val() + "_" + $("#toLangSelect").val()).val('Y')
	}

	function fromGroupSelectChange(event)
	{
		$("#toGroupText").val($(".toGroupsDescriptionsText_" + $("#fromGroupSelect").val() + '_' + $('#toLangSelect').val()).val())
		initializeproducts();
	}

	function initializeproducts()
	{
		$('.product').prop('hidden', true)

		var initialGroup = $('.groupoption_'+ $('#fromGroupSelect').prop('selectedIndex')).prop('id')

		$.get('/productsingroup',
			{lang:$('#fromLangSelect').val(),
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
			{lang:$('#toLangSelect').val(),
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

</script>
@endsection