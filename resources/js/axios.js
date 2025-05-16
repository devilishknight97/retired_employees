import axios from "axios";
import Cookies from 'js-cookie';

// http://RetiredEmployees.test/app

const httpApi = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    withCredentials: true,
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      'Content-Type': 'application/json',
    },
  });

httpApi.interceptors.request.use(function (config) {
    const token = Cookies.get('XSRF-TOKEN');
    if (token) {
      config.headers['X-XSRF-TOKEN'] = token;
    }
    return config;
  }, function (error) {
    return Promise.reject(error);
  });

export default httpApi;
