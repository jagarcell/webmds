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
						<option value="{{$group->groupid}}"  style="width: 20%; overflow-wrap: all;">
							{{$group->groupsdescriptions[0]->description}}
						</option>
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
						<select id="fromProductSelect" style="width: 100%;">

						</select>
					</div>
					<div style="width: 45%; float: right; margin-right: 0px; margin-top: 20px;">
						<textarea spellcheck="false" id="toProductText" style="width: 100%; height: 20px; text-transform: uppercase;">
						</textarea>
					</div>
				</div>
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
		$("#fromProductSelect").on('change', fromProductSelectChange)
		$("#toProductText").on('change', toProductTextChange)

		initializeGroups();
	});

	function fromLangSelectChanged(event)
	{
		var fromGroupSelectVal = $("#fromGroupSelect").val()
		var fromGroupSelectSelectedIndex = $("#fromGroupSelect").prop('selectedIndex')
		initializeGroups()
		$("#fromGroupSelect").prop('selectedIndex', fromGroupSelectSelectedIndex)
	}

	function fromGroupSelectChange(event)
	{
		$.get('/groupbyid',
			{
				lang: $("#toLangSelect").val(),
				groupid: $("#fromGroupSelect").val()
			},
			function(data, status){
				var group = JSON.parse(data)
				var toGroupText = group[0]['groupsdescriptions'][0]['description']
				$("#toGroupText").val(toGroupText)
				initializeproducts()
			}
		)
	}

	function fromProductSelectChange(event)
	{
		productById($("#fromProductSelect").val(), $("#toLangSelect").val())
	}

	function toLangSelectChanged(event)
	{
		groupById($("#fromGroupSelect").val(), $("#toLangSelect").val())
		productById($("#fromProductSelect").val(), $("#toLangSelect").val())
	}

	function toGroupTextChange(event)
	{
		$.get('/translatedGroupUpdate',
			{groupid: $("#fromGroupSelect").val(),
			lang: $("#toLangSelect").val(),
			description: $("#toGroupText").val()},
			function(data, status){
				var group = JSON.parse(data)
				console.log(group)
			})
	}

	function toProductTextChange()
	{
		$.get('/translatedProductUpdate',
			{productid: $('#fromProductSelect').val(),
			lang: $('#toLangSelect').val(),
			description: $('#toProductText').val()},
			function(data, status){

			})
	}

	function groupById(groupid, lang)
	{
		$.get('/groupbyid',
			{lang: lang,
			 groupid: groupid,
			},
			function(data, status){
				var group = JSON.parse(data)
				var toGroupText = group[0]['groupsdescriptions'][0]['description']
				$("#toGroupText").val(toGroupText)
		})
	}

	function productById(productid, lang)
	{

		$.get('/productbyid',
			{productid: productid,
			lang: lang},
			function(data, status){
				var product = JSON.parse(data)
				$("#toProductText").val(product[0]['productsdescriptions'][0]['description'])
		})
	}

	function initializeGroups()
	{
		$.get('/groups',
			{lang: $("#fromLangSelect").val()},
			function(data, status){
				var groups = JSON.parse(data)
				for(key in groups)
				{
					$("#fromGroupSelect").prop('options')[key]['text'] = groups[key]['groupsdescriptions'][0].description;
				}
				groupById($("#fromGroupSelect").val(), $("#toLangSelect").val())
			}
		)
		initializeproducts()
	}

	function initializeproducts()
	{
		$.get('/productsingroup',
			{lang: $("#fromLangSelect").val(),
			groupid: $("#fromGroupSelect").val()},
			function(data, status){
				var products = JSON.parse(data)
				$("#fromProductSelect").empty();
				for(var i = 0; i < products.length; i++)
				{
					$("#fromProductSelect").append('<option value=' + products[i]['productid'] + '>' + products[i]['productsdescriptions'][0]['description'] + '</option>')
				}
				productById(products[0]['productid'], $("#toLangSelect").val())
			})
	}

	function groupTextFocus(textElement)
	{
	}

</script>
@endsection