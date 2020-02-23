function formValidation()
{	
	var addressLine1 = document.addOfficeForm.addressLine1.value;
	var phone = document.addOfficeForm.phone.value;
	var country = document.addOfficeForm.country.value;
	var state = document.addOfficeForm.state.value;
	var city = document.addOfficeForm.city.value;

	var fnm_vali = /^[A-Za-z ]+$/;
	var email_vali = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var contact_vali = /^[0-9]+$/;
	var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
	var url_vali = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/g;


	
	if(addressLine1==null || addressLine1==""){
		$(document.addOfficeForm.addressLine1).addClass('form-error').parent().siblings('small').addClass('error').html('Address is Required');
		$('#addressLine1').focus();
		return false;		
	}else{
		$(document.addOfficeForm.addressLine1).removeClass('form-error').parent().siblings('small').addClass('error').html('');
	}

	if(phone=="" && phone==null){
		$('#phone').focus();
		$(phone).addClass('form-error').parent().siblings('small').addClass('error').html('Contact is Required');
		return false;
	}else if(!contact_vali.test(phone)){
		$('#phone').focus();
		$(phone).addClass('form-error').parent().siblings('small').addClass('error').html('Contact number should be valid');
		return false;
	}else if(phone.length != 10){
		$('#phone').focus();
		$(phone).addClass('form-error').parent().siblings('small').addClass('error').html('Contact number should be 10 digit');
		return false;
	}else{
		$(phone).removeClass('form-error').parent().siblings('small').addClass('error').html('');
	}


	if(city=="" || city==null ){
		$('#city').focus();
		$(document.addOfficeForm.city).addClass('form-error').siblings('small').html('City name is Required');
		return false;
	}else if(!fnm_vali.test(city)){
		$('#city').focus();
		$(document.addOfficeForm.city).addClass('form-error').siblings('small').html('Full Name should be string or valid');
		return false;
	}else{
		$(document.addOfficeForm.city).removeClass('form-error').siblings('small').html('');
	}
	
	if(country==null || country==""){
		$(document.addOfficeForm.country).addClass('form-error').parent().siblings('small').addClass('error').html('Country is Required');
		$('#country').focus();
		return false;		
	}

	
	if(state==null || state==""){
		$(document.addOfficeForm.state).addClass('form-error').parent().siblings('small').addClass('error').html('Country is Required');
		$('#state').focus();
		return false;		
	}

	return true;
}