function getCart(){ try { return JSON.parse(localStorage.getItem('cart')||'[]'); } catch { return []; } }
function saveCart(arr){ localStorage.setItem('cart', JSON.stringify(arr)); }

function showToast(message, isError = false) {
  const existing = document.querySelector('.toast');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.className = 'toast' + (isError ? ' error' : '');
  toast.textContent = message;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.classList.add('hide');
    setTimeout(() => toast.remove(), 400);
  }, 3000);
}

function addToCart(m){
  const customer = getCustomer();
  if (!customer || !customer.customer_id) {
    showToast('Խնդրում ենք մուտք գործել հաշիվ', true);
    return;
  }

  const cart = getCart();
  const i = cart.findIndex(x=>x.menuitem_id===m.menuitem_id);
  if (i>=0) cart[i].qty += 1;
  else cart.push({menuitem_id:m.menuitem_id, name:m.name, price:Number(m.price), qty:1});
  saveCart(cart);
  showToast('Ավելացվեց պայուսակ');
}

function changeQty(id, delta){
  const customer = getCustomer();
  if (!customer || !customer.customer_id) {
    showToast('Խնդրում ենք մուտք գործել հաշիվ', true);
    return;
  }

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
