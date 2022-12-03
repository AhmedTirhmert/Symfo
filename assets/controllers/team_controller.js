/** @format */

import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

export default class extends Controller {
  static targets = ['formContainer', 'form', 'loader'];
  connect() {}
  async onSubmit(e) {
    e.preventDefault();
    try {
      // this.loaderTarget.classList.toggle('hidden');
      let form = new FormData(e.target);

      let { data } = await axios.post('/api/team/store', form);
      console.log(data);
      // this.loaderTarget.classList.toggle('hidden');
    } catch (error) {
        console.log(error);
    }
  }
}
