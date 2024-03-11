// ici j'ia configurer mon forlulaire pour quill ne s'affiche completemnt que pour les vendeur 
//sino de bse il affiche juste les chmps necessaire pour la viviteur/clients

window.onload = (event) => {
  
    var sellerCheckbox = document.querySelector('#registration_form_isSeller');
    var sellerForm = document.getElementById('sellerForm');
    
    if(sellerCheckbox) {

        sellerCheckbox.addEventListener('change', function() {
            if (sellerCheckbox.checked) {
                sellerForm.style.display = 'block';
            } else {
                sellerForm.style.display = 'none';
            }
        });
    }  
};
