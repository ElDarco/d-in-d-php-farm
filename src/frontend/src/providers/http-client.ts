import axios, {AxiosError, AxiosInstance, AxiosPromise, AxiosRequestConfig} from 'axios';

export default abstract class HttpClient {
  protected axios: AxiosInstance;

  public constructor() {
    this.axios = axios.create({
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Pragma': 'no-cache',
      },
    });

    this.axios.interceptors.request.use(this.beforeRequest.bind(this), this.requestErrorHandler);
  }

  public get(url: string, config: object = {}): AxiosPromise {
    return this.axios.get(url, config);
  }

  public post(url: string, params: object = {}, config: object = {}): AxiosPromise {
    return this.axios.post(url, params, config);
  }

  public put(url: string, params: object = {}, config: object = {}): AxiosPromise {
    return this.axios.put(url, params, config);
  }

  public patch(url: string, params: object = {}, config: object = {}): AxiosPromise {
    return this.axios.patch(url, params, config);
  }

  public delete(url: string, config: object = {}): AxiosPromise {
    return this.axios.delete(url, config);
  }

  protected beforeRequest(config: AxiosRequestConfig): AxiosRequestConfig {
    return config;
  }

  protected requestErrorHandler(error: AxiosError): Promise<void> {
    return Promise.reject(error);
  }
}
