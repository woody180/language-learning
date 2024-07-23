const baseurl = document.querySelector('meta[name="baseurl"]').getAttribute('content');

import MainClass from "./classes/MainClass.js";

const mainClass = new MainClass(baseurl);