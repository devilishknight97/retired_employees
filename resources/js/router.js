// resources/js/router.js

import { createRouter, createWebHistory } from 'vue-router';
import Employees from './components/Employees.vue';           // Landing page with two buttons
import EmployeeForm from './components/EmployeeForm.vue';         // Add employee form
import EmployeesContainer from './components/EmployeesContainer.vue'; // Employee list view
import EmployeeEdit from './components/EmployeeEdit.vue';         // Edit employee
import LoginPage from './components/LoginPage.vue';               // Login page
import EmployeeDetail from './components/EmployeeDetail.vue';     // Employee Page
import PdfViewer from './components/PdfViewer.vue';
const routes = [
  {
    path: '/app/login',
    name: 'Login',
    component: LoginPage,
  },
  {
    path: '/app/',
    name: 'RetiredEmployees',
    component: Employees,
    meta: { requiresAuth: true },
  },
  {
    path: '/app/employees',
    name: 'EmployeeList',
    component: EmployeesContainer,
    meta: { requiresAuth: true },
  },
  {
    path: '/app/add-employee',
    name: 'AddEmployee',
    component: EmployeeForm,
    meta: { requiresAuth: true },
  },
  {
    path: '/app/edit/:employee_number',
    name: 'EmployeeEdit',
    component: EmployeeEdit,
    meta: { requiresAuth: true },
  },

  {
    path: '/app/employee/:employee_number',
    name: 'EmployeeDetail',
    component: EmployeeDetail,
    meta: { requiresAuth: true },
  },

  {
    path: '/app/pdf-viewer',
    name: 'PdfViewer',
    component: PdfViewer,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const isAuthenticated = () => !!localStorage.getItem("token");

router.beforeEach((to, from, next) => {
  if (to.path !== "/app/login" && !isAuthenticated()) {
    next("/app/login"); // Redirect to login if not authenticated
  } else if (to.path === "/app/login" && isAuthenticated()) {
    next("/app/"); // If already logged in, send to main page
  } else {
    next();
  }
});


export default router;
