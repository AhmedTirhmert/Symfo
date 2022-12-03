/** @format */

import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ['formContainer', 'newTeamForm'];
  static formContainer;
  static newTeamForm;
  async loadForm(e) {
    e.preventDefault();
    let { data } = await axios.get('/api/team/create');
    this.newTeamForm.innerHTML = data.form
  }
  connect() {
    this.formContainer = this.formContainerTarget;
    this.newTeamForm = this.newTeamFormTarget;
  }
}
