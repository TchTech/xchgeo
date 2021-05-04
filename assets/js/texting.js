function changeSelectedDay(SelectId, ChangeId){
    var SelectElem = document.getElementById(SelectId)
    var ChangeElem = document.getElementById(ChangeId)
    var day = SelectElem.options[SelectElem.selectedIndex].text
    var data_type = SelectId.split('-')[0]
    switch(data_type){
        case 'pr':
            var data_in_day = pr_data[day-1]
            break
        case 'temp':
            var data_in_day = temp_data[day-1]
            break
    }
    if(data_in_day == undefined){
        ChangeElem.innerHTML = "{Выбранный день отсутствует}"
    }
    else{
    ChangeElem.innerHTML = data_in_day
    }
}