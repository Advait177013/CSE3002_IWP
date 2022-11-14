function calc()
{
    var ad=document.getElementById("adults").value;
    var kds=document.getElementById("kids").value;
    var val=10*ad+5*kds;
    document.getElementById("result").value=val;
}