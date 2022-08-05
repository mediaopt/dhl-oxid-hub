if (document.getElementsByClassName('processIdentifier').length > 0) {
  document.getElementsByClassName('processIdentifier')[0].addEventListener('change', (event) => {
    document.getElementById('mo_dhl_process_settings').className = event.target.value;
  });
}
if (document.getElementsByClassName('deliverySettings').length > 0) {
  Array.from(document.getElementsByClassName('deliverySettings')).forEach(setting => {
    setting.addEventListener('change', event => {
      if (event.target.checked) {
        Array.from(document.getElementsByClassName('deliverySettings')).forEach(otherSetting => {
          if (setting !== otherSetting) {
            otherSetting.checked = false;
          }
        });
      }
    });
  })
}