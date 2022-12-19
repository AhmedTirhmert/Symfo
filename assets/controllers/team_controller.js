/** @format */

import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
import Swal from 'sweetalert2';

export default class extends Controller {
  static targets = ['formContainer', 'form', 'loader'];
  connect() {}
  async onSubmit(e) {
    e.preventDefault();
    
    this.loaderTarget.classList.toggle('hidden');
    try {
      let form = new FormData(e.target);
      let { data } = await axios.post('/api/team/store', form);
      Swal.fire('Success', data.message, 'success');
    } catch (error) {
      let contentContainer = document.getElementById('contentContainer');
      contentContainer.innerHTML = error.response.data.form;
    }
    this.loaderTarget.classList.toggle('hidden');
  }
}
