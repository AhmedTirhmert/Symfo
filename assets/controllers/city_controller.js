/** @format */

import { Controller } from '@hotwired/stimulus';

import Map from 'ol/Map';
import View from 'ol/View';
import TileLayer from 'ol/layer/Tile';
import XYZ from 'ol/source/XYZ';
import { useGeographic } from 'ol/proj';
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
  static targets = [
    'formContainer',
    'newTeamForm',
    'map',
    'latitude',
    'longitude',
  ];

  connect() {
    useGeographic();
    const map = new Map({
      target: this.mapTarget,
      layers: [
        new TileLayer({
          source: new XYZ({
            url: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
          }),
        }),
      ],
      view: new View({
        center: [this.longitudeTarget.value, this.latitudeTarget.value],
        zoom: 9,
      }),
      controls: [],
    });
    console.log(map);
  }
}
