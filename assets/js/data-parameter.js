function parameterChange(selectid){
    var selectelem = document.getElementById(selectid)
    var parameter = selectelem.options[selectelem.selectedIndex].text
    sessionStorage.getItem('label')
    sessionStorage.setItem('label', 'value')
    alert(00)
}