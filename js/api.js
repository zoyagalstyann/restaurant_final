function getCustomer(){
  try { return JSON.parse(localStorage.getItem('customer')||'null'); } catch { return null; }
}

function signOut(){
  localStorage.removeItem('customer');
  localStorage.removeItem('cart');
  window.location.href = 'index.html';
}

function updateNavAuth(){
  const customer = getCustomer();
  const navDiv = document.querySelector('.nav > .container > div:last-child');
  if (!navDiv) return;

  const authLink = navDiv.querySelector('a[href="auth.html"]');
  if (!authLink) return;

  if (customer && customer.customer_id){
    authLink.textContent = 'Ելք (' + customer.name + ')';
    authLink.href = '#';
    authLink.onclick = (e)=>{ e.preventDefault(); signOut(); };
  } else {
    authLink.textContent = 'Մուտք / Գրանցում';
    authLink.href = 'auth.html';
    authLink.onclick = null;
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', updateNavAuth);
} else {
  updateNavAuth();
}
