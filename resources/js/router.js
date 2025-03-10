// resources/js/router.js
import { createRouter, createWebHistory } from 'vue-router';
import Employees from './components/Employees.vue';      // A landing page with two buttons
import EmployeeForm from './components/EmployeeForm.vue';        // The form to add an employee
import EmployeesContainer from './components/EmployeesContainer.vue'; // The list view
import EmployeeEdit from './components/EmployeeEdit.vue'; // To edit employees

const routes = [
  {
    path: '/app/',
    name: 'Retired Employees',
    component: Employees,
  },
  {
    path: '/app/employees',
    name: 'Employees',
    component: EmployeesContainer,
  },
  {
    path: '/app/add-employee',
    name: 'AddEmployee',
    component: EmployeeForm,
  },

  {
    name: 'Edit Employee',
    path: "/app/edit/:employee_number",
    component: EmployeeEdit
  }
  
  // You can add more routes as needed.
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
