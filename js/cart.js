// պահում ենք localStorage-ում
function getCart(){ try { return JSON.parse(localStorage.getItem('cart')||'[]'); } catch { return []; } }
function saveCart(arr){ localStorage.setItem('cart', JSON.stringify(arr)); }
function addToCart(m){
  const cart = getCart();
  const i = cart.findIndex(x=>x.menuitem_id===m.menuitem_id);
  if (i>=0) cart[i].qty += 1;
  else cart.push({menuitem_id:m.menuitem_id, name:m.name, price:Number(m.price), qty:1});
  saveCart(cart);
  alert('Ավելացվեց պայուսակ');
}
function changeQty(id, delta){
  const cart = getCart();
  const i = cart.findIndex(x=>x.menuitem_id===id);
  if (i>=0){
    cart[i].qty += delta;
    if (cart[i].qty<=0) cart.splice(i,1);
    saveCart(cart);
    if (typeof render==='function') render();
  }
}
function clearCart(){ saveCart([]); }
