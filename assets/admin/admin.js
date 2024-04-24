// main scss file

require('./scss/app.scss');

// JS PART =============================================================================================================

// js components
import { MainChart } from "./js/components/MainChart";

// init after dom load
$(function () {
    new MainChart();
});

// VUE PART ============================================================================================================
import {VueApp} from "../common/VueApp";
import UserGroupList from "./vue/UserGroup/UserGroupList";

const vueComponents = {
    'user-group-list-component': UserGroupList,
};
new VueApp(vueComponents);
