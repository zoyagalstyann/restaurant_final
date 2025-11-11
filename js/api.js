// փոքր օգնականներ՝ հաճախորդի տվյալների համար
function getCustomer() {
  try {
    return JSON.parse(localStorage.getItem('customer') || 'null');
  } catch {
    return null;
  }
}

function setCustomer(customer) {
  if (customer) {
    localStorage.setItem('customer', JSON.stringify(customer));
  }
  updateAuthUI();
}

function clearCustomer() {
  localStorage.removeItem('customer');
  updateAuthUI();
}

function requireCustomer() {
  const customer = getCustomer();
  if (!customer) {
    window.location.href = 'auth.html';
    return null;
  }
  return customer;
}

function updateAuthUI() {
  const customer = getCustomer();
  const loginEls = document.querySelectorAll('[data-auth="login"]');
  const accountEls = document.querySelectorAll('[data-auth="account"]');
  loginEls.forEach((el) => {
    el.style.display = customer ? 'none' : '';
  });
  accountEls.forEach((el) => {
    if (customer) {
      el.style.display = 'flex';
      const nameEl = el.querySelector('.nav-account-name');
      if (nameEl) {
        nameEl.textContent = customer.name + ' ' + customer.lastname;
      }
    } else {
      el.style.display = 'none';
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  updateAuthUI();
  document.querySelectorAll('.nav-logout').forEach((btn) => {
    btn.addEventListener('click', (ev) => {
      ev.preventDefault();
      clearCustomer();
      window.location.href = 'index.html';
    });
  });
});

window.getCustomer = getCustomer;
window.setCustomer = setCustomer;
window.clearCustomer = clearCustomer;
window.requireCustomer = requireCustomer;
