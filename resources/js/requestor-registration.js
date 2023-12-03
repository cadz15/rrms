var isPage3 = false;

const requiredValidation = (val, type, val2 = '') => {

    if(type === 'string') {

        return String(val).trim().length  < 3;
    }else if(type === 'contact-number') {
        
        return String(val).trim().length  < 11;
    }else if(type === 'confirm') {

        return val !== val2;
    }else if(type === 'year-level'){

        return Number(val) > 5 || Number(val) <= 0;
    }else {

        return val === '';
    }
}


const displayTextToPage3 = () => {

    document.getElementById('student_number_text').innerHTML = document.getElementById('student_number').value;
    document.getElementById('last_name_text').innerHTML = document.getElementById('last_name').value;
    document.getElementById('first_name_text').innerHTML = document.getElementById('first_name').value;
    document.getElementById('middle_name_text').innerHTML = document.getElementById('middle_name').value;
    document.getElementById('suffix_text').innerHTML = document.getElementById('suffix').value;
    document.getElementById('sex_text').innerHTML = document.getElementById('sex').selectedOptions[0].text;
    document.getElementById('contact_number_text').innerHTML = document.getElementById('contact_number').value;
    document.getElementById('birthday_text').innerHTML = document.getElementById('birth_date').value;
    document.getElementById('birth_place_text').innerHTML = document.getElementById('birth_place').value;
    document.getElementById('address_text').innerHTML = document.getElementById('address').value;
    
    
    document.getElementById('degree_text').innerHTML = document.getElementById('degree').selectedOptions[0].text;
    // document.getElementById('major_text').innerHTML = document.getElementById('major').selectedOptions[0].text;
    document.getElementById('date_enrolled_text').innerHTML = document.getElementById('date_enrolled').value;
    document.getElementById('year_level_text').innerHTML = document.getElementById('year_level').value;
    document.getElementById('is_graduated_text').innerHTML = document.getElementById('is_graduated').selectedOptions[0].text;
    document.getElementById('date_graduated_text').innerHTML = document.getElementById('date_graduated').value;

}


const page1 = () => {
    let hasError = false;
    let requiredElement = ['last_name', 'first_name', 'sex', 'contact_number', 'birth_date', 'birth_place', 'address'];

    let indicator = document.getElementById('page-1-indicator');
    let page2Indicator = document.getElementById('page-2-indicator');

    let page1 = document.getElementById('page-1');
    let page2 = document.getElementById('page-2');

    let indicatorSuccessIcon = document.getElementById('page-1-success-icon');
    let indicatorDangerIcon = document.getElementById('page-1-danger-icon');
    let indicatorPrimaryIcon = document.getElementById('page-1-primary-icon');

    let page2IndicatorSuccessIcon = document.getElementById('page-2-success-icon');
    let page2IndicatorDangerIcon = document.getElementById('page-2-danger-icon');
    let page2IndicatorPrimaryIcon = document.getElementById('page-2-primary-icon');

    let el = document.querySelectorAll('.is-invalid');

    for(let element of el) {
        if(requiredElement.includes(element.id)) {
            element.classList.remove('is-invalid');
        }
    }


    if(requiredValidation(document.getElementById('last_name').value, 'string')){
        hasError = true;
        document.getElementById('last_name').classList.add('is-invalid');
    };
    
    if(requiredValidation(document.getElementById('first_name').value, 'string')){
        hasError = true;
        document.getElementById('first_name').classList.add('is-invalid');
    };
    
    if(requiredValidation(document.getElementById('sex').value, 'string')){
        hasError = true;
        document.getElementById('sex').classList.add('is-invalid');
    };
    
    if(requiredValidation(document.getElementById('contact_number').value, 'contact-number')){
        hasError = true;
        document.getElementById('contact_number').classList.add('is-invalid');
    };
    
    if(!requiredValidation(document.getElementById('used').value, 'confirm', document.getElementById('contact_number').value)){
        hasError = true;
        document.getElementById('contact_number').classList.add('is-invalid');
    };
    
    if(requiredValidation(document.getElementById('birth_date').value, 'string')){
        hasError = true;
        document.getElementById('birth_date').classList.add('is-invalid');
    };
    
    if(requiredValidation(document.getElementById('birth_place').value, 'string')){
        hasError = true;
        document.getElementById('birth_place').classList.add('is-invalid');
    };
    
    if(requiredValidation(document.getElementById('address').value, 'string')){
        hasError = true;
        document.getElementById('address').classList.add('is-invalid');
    };
    

    if(hasError) {
        indicator.classList.remove('step-success');
        indicator.classList.remove('step-primary');
        indicator.classList.add('step-danger');

        indicatorSuccessIcon.classList.add('hidden');
        indicatorDangerIcon.classList.remove('hidden');
        indicatorPrimaryIcon.classList.add('hidden');
    }else {        
        indicator.classList.add('step-success');
        indicator.classList.remove('step-primary');
        indicator.classList.remove('step-danger');
        indicator.classList.remove('active-step');

        page2Indicator.classList.add('active-step');
        page2Indicator.classList.add('step-primary');
        
        indicatorSuccessIcon.classList.remove('hidden');
        indicatorDangerIcon.classList.add('hidden');
        indicatorPrimaryIcon.classList.add('hidden');

        page2IndicatorSuccessIcon.classList.add('hidden');
        page2IndicatorDangerIcon.classList.add('hidden');
        page2IndicatorPrimaryIcon.classList.remove('hidden');

        page1.classList.add('hidden');
        page2.classList.remove('hidden');
    }
    
    isPage3 = false;
}


const goBackPage1 = () => {
    let indicator = document.getElementById('page-1-indicator');
    let page2Indicator = document.getElementById('page-2-indicator');

    let page1 = document.getElementById('page-1');
    let page2 = document.getElementById('page-2');

    let indicatorSuccessIcon = document.getElementById('page-1-success-icon');
    let indicatorDangerIcon = document.getElementById('page-1-danger-icon');
    let indicatorPrimaryIcon = document.getElementById('page-1-primary-icon');

    indicator.classList.add('step-success');
    indicator.classList.remove('step-primary');
    indicator.classList.remove('step-danger');
    indicator.classList.add('active-step');
    indicator.classList.add('step-primary');
    indicator.classList.remove('step-success');
    indicator.classList.remove('step-danger');

    page2Indicator.classList.remove('active-step');
    page2Indicator.classList.remove('step-primary');
    page2Indicator.classList.remove('step-success');
    page2Indicator.classList.remove('step-danger');
    
    indicatorSuccessIcon.classList.add('hidden');
    indicatorDangerIcon.classList.add('hidden');
    indicatorPrimaryIcon.classList.remove('hidden');

    page1.classList.remove('hidden');
    page2.classList.add('hidden');

    
    isPage3 = false;
}


const page2 = () => {
    let hasError = false;
    let requiredElement = ['degree', 'major', 'date_enrolled', 'year_level'];

    let indicator = document.getElementById('page-2-indicator');
    let page3Indicator = document.getElementById('page-3-indicator');

    let page2 = document.getElementById('page-2');
    let page3 = document.getElementById('page-3');

    let indicatorSuccessIcon = document.getElementById('page-2-success-icon');
    let indicatorDangerIcon = document.getElementById('page-2-danger-icon');
    let indicatorPrimaryIcon = document.getElementById('page-2-primary-icon');

    let page3IndicatorSuccessIcon = document.getElementById('page-3-success-icon');
    let page3IndicatorDangerIcon = document.getElementById('page-3-danger-icon');
    let page3IndicatorPrimaryIcon = document.getElementById('page-3-primary-icon');

    let el = document.querySelectorAll('.is-invalid');

    for(let element of el) {
        if(requiredElement.includes(element.id)) {
            element.classList.remove('is-invalid');
        }
    }


    
    if(requiredValidation(document.getElementById('degree').value, '')){
        hasError = true;
        document.getElementById('degree').classList.add('is-invalid');
    };
    
    // if(requiredValidation(document.getElementById('major').value, '')){
    //     hasError = true;
    //     document.getElementById('major').classList.add('is-invalid');
    // };
    
    if(requiredValidation(document.getElementById('date_enrolled').value, 'string')){
        hasError = true;
        document.getElementById('date_enrolled').classList.add('is-invalid');
    };
    
    // if(requiredValidation(document.getElementById('year_level').value, 'year-level')){
    //     hasError = true;
    //     document.getElementById('year_level').classList.add('is-invalid');
    // };


    if(hasError) {
        indicator.classList.remove('step-success');
        indicator.classList.remove('step-primary');
        indicator.classList.add('step-danger');

        indicatorSuccessIcon.classList.add('hidden');
        indicatorDangerIcon.classList.remove('hidden');
        indicatorPrimaryIcon.classList.add('hidden');
    }else {        
        indicator.classList.add('step-success');
        indicator.classList.remove('step-primary');
        indicator.classList.remove('step-danger');
        indicator.classList.remove('active-step');

        page3Indicator.classList.add('active-step');
        page3Indicator.classList.add('step-primary');
        
        indicatorSuccessIcon.classList.remove('hidden');
        indicatorDangerIcon.classList.add('hidden');
        indicatorPrimaryIcon.classList.add('hidden');

        page3IndicatorSuccessIcon.classList.add('hidden');
        page3IndicatorDangerIcon.classList.add('hidden');
        page3IndicatorPrimaryIcon.classList.remove('hidden');

        page2.classList.add('hidden');
        page3.classList.remove('hidden');

        displayTextToPage3();

        
        isPage3 = false;
    }
}


const goBackPage2 = () => {
    let indicator = document.getElementById('page-2-indicator');
    let page3Indicator = document.getElementById('page-3-indicator');

    let page2 = document.getElementById('page-2');
    let page3 = document.getElementById('page-3');

    let indicatorSuccessIcon = document.getElementById('page-2-success-icon');
    let indicatorDangerIcon = document.getElementById('page-2-danger-icon');
    let indicatorPrimaryIcon = document.getElementById('page-2-primary-icon');

    let page3IndicatorSuccessIcon = document.getElementById('page-3-success-icon');
    let page3IndicatorDangerIcon = document.getElementById('page-3-danger-icon');
    let page3IndicatorPrimaryIcon = document.getElementById('page-3-primary-icon');

    indicator.classList.remove('step-success');
    indicator.classList.add('step-primary');
    indicator.classList.remove('step-danger');
    indicator.classList.add('active-step');

    page3Indicator.classList.remove('active-step');
    page3Indicator.classList.remove('step-primary');
    
    indicatorSuccessIcon.classList.add('hidden');
    indicatorDangerIcon.classList.add('hidden');
    indicatorPrimaryIcon.classList.remove('hidden');

    page3IndicatorSuccessIcon.classList.add('hidden');
    page3IndicatorDangerIcon.classList.add('hidden');
    page3IndicatorPrimaryIcon.classList.remove('hidden');

    page2.classList.remove('hidden');
    page3.classList.add('hidden');

    isPage3 = false;
}


if (document.readyState === "interactive") { 
    // register form
    document.getElementById('register-form').addEventListener('submit', function(e) {
        if(!isPage3) {
            e.preventDefault();
        }
    }); 


    // contact number event. Allow only numbers
    document.getElementById('contact_number').addEventListener('keydown', function(e) {
        let charCode = e.which;
        let allowedKey = [8, 9, 37, 39, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57];

        if(e.target.value.length === 11 && [8,46].includes(charCode)) {
            return true;
        }

        if(allowedKey.includes(charCode) && e.target.value.length < 11) {
            return true;
        };
        console.log(charCode, e.target.value.length);
        e.preventDefault();
        return false;
    });

    // contact number event. Allow only numbers
    document.getElementById('year_level').addEventListener('keydown', function(e) {
        let charCode = e.which;
        let allowedKey = [8, 9, 37, 39, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57];

        if(allowedKey.includes(charCode) && e.target.value.length < 11) {
            return true;
        };
        
        e.preventDefault();
        return false;
    });

    //page1 button
    document.getElementById('goto-page-2').addEventListener('click', function() {
        page1();
    });

    //go back to page1 button
    document.getElementById('go-back-page-1').addEventListener('click', function() {
        goBackPage1();
    });

    //page2 button
    document.getElementById('goto-page-3').addEventListener('click', function() {
        page2();
    });

    //go back to page2 button
    document.getElementById('go-back-page-2').addEventListener('click', function() {
        goBackPage2();
    });

    //submit form
    document.getElementById('register-requestor').addEventListener('click', function(e) {
        
        isPage3 = true;
        e.target.submit();
    });
}
