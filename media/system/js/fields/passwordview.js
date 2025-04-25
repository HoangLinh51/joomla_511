/**
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
(document => {

  document.addEventListener('DOMContentLoaded', () => {
    [].slice.call(document.querySelectorAll('input[type="password"]')).forEach(input => {
      const toggleButton = input.parentNode.querySelector('.input-password-toggle');
      if (toggleButton) {
        toggleButton.addEventListener('click', () => {
          const icon = toggleButton.firstElementChild;
          const srText = toggleButton.lastElementChild;
          if (input.type === 'password') {
            // Update the icon class
            icon.classList.remove('icon-eye');
            icon.classList.add('icon-eye-slash');

            // Update the input type
            input.type = 'text';

            // Focus the input field
            input.focus();

            // Update the text for screenreaders
            srText.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
    <path d="M432,448a15.92,15.92,0,0,1-11.31-4.69l-352-352A16,16,0,0,1,91.31,68.69l352,352A16,16,0,0,1,432,448Z" />
    <path d="M255.66,384c-41.49,0-81.5-12.28-118.92-36.5-34.07-22-64.74-53.51-88.7-91l0-.08c19.94-28.57,41.78-52.73,65.24-72.21a2,2,0,0,0,.14-2.94L93.5,161.38a2,2,0,0,0-2.71-.12c-24.92,21-48.05,46.76-69.08,76.92a31.92,31.92,0,0,0-.64,35.54c26.41,41.33,60.4,76.14,98.28,100.65C162,402,207.9,416,255.66,416a239.13,239.13,0,0,0,75.8-12.58,2,2,0,0,0,.77-3.31l-21.58-21.58a4,4,0,0,0-3.83-1A204.8,204.8,0,0,1,255.66,384Z" />
    <path d="M490.84,238.6c-26.46-40.92-60.79-75.68-99.27-100.53C349,110.55,302,96,255.66,96a227.34,227.34,0,0,0-74.89,12.83,2,2,0,0,0-.75,3.31l21.55,21.55a4,4,0,0,0,3.88,1A192.82,192.82,0,0,1,255.66,128c40.69,0,80.58,12.43,118.55,37,34.71,22.4,65.74,53.88,89.76,91a.13.13,0,0,1,0,.16,310.72,310.72,0,0,1-64.12,72.73,2,2,0,0,0-.15,2.95l19.9,19.89a2,2,0,0,0,2.7.13,343.49,343.49,0,0,0,68.64-78.48A32.2,32.2,0,0,0,490.84,238.6Z" />
    <path d="M256,160a95.88,95.88,0,0,0-21.37,2.4,2,2,0,0,0-1,3.38L346.22,278.34a2,2,0,0,0,3.38-1A96,96,0,0,0,256,160Z" />
    <path d="M165.78,233.66a2,2,0,0,0-3.38,1,96,96,0,0,0,115,115,2,2,0,0,0,1-3.38Z" />
</svg>`;

          } else if (input.type === 'text') {
            // Update the icon class
            icon.classList.add('icon-eye');
            icon.classList.remove('icon-eye-slash');

            // Update the input type
            input.type = 'password';

            // Focus the input field
            input.focus();

            // Update the text for screenreaders
            srText.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
    <path d="M255.66,112c-77.94,0-157.89,45.11-220.83,135.33a16,16,0,0,0-.27,17.77C82.92,340.8,161.8,400,255.66,400,348.5,400,429,340.62,477.45,264.75a16.14,16.14,0,0,0,0-17.47C428.89,172.28,347.8,112,255.66,112Z" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" />
    <circle cx="256" cy="256" r="80" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:32px" />
</svg>`
          }
        });
      }
      const modifyButton = input.parentNode.querySelector('.input-password-modify');
      if (modifyButton) {
        modifyButton.addEventListener('click', () => {
          const lock = !modifyButton.classList.contains('locked');
          if (lock === true) {
            // Add lock
            modifyButton.classList.add('locked');

            // Reset value to empty string
            input.value = '';

            // Disable the field
            input.setAttribute('disabled', '');

            // Update the text
            modifyButton.innerText = Joomla.Text._('JMODIFY');
          } else {
            // Remove lock
            modifyButton.classList.remove('locked');

            // Enable the field
            input.removeAttribute('disabled');

            // Focus the input field
            input.focus();

            // Update the text
            modifyButton.innerText = Joomla.Text._('JCANCEL');
          }
        });
      }
    });
  });
})(document);
