// փոքր օգնականներ
function getCustomer(){
  try { return JSON.parse(localStorage.getItem('customer')||'null'); } catch { return null; }
}
