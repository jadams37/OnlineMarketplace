
document.addEventListener('DOMContentLoaded', () => {
    const slides  = document.querySelectorAll('.deal-slide');
    const nameEl  = document.getElementById('dealName');
    const priceEl = document.getElementById('dealPrice');
    let idx = 0;
  
    function showSlide(i) {
      slides.forEach(s => s.style.display = 'none');
      const s = slides[i];
      s.style.display = 'block';
  
      const name       = s.dataset.name;
      const orig       = parseFloat(s.dataset.orig);
      const disc       = parseFloat(s.dataset.disc);
      const listingId  = s.dataset.listingid;
  
      // Update the right-hand text
      nameEl.textContent = name;
      priceEl.innerHTML  = `<del>$${orig.toFixed(2)}</del> <span>$${disc.toFixed(2)}</span>`;
  
      // Wire up the links
      const purchaseBtn = document.getElementById('dealPurchase');
      const cartBtn     = document.getElementById('dealAddCart');
  
      purchaseBtn.textContent = 'View Item';
      purchaseBtn.href        = `product.php?listing_id=${listingId}`;
  
      cartBtn.href            = `cart.php?add=${listingId}`;
    }
  
    document.getElementById('prevDeal').addEventListener('click', () => {
      idx = (idx - 1 + slides.length) % slides.length;
      showSlide(idx);
    });
  
    document.getElementById('nextDeal').addEventListener('click', () => {
      idx = (idx + 1) % slides.length;
      showSlide(idx);
    });
  
    showSlide(0);
  });
  