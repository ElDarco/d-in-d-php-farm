import HttpClient from "@/providers/http-client";
import {AxiosRequestConfig} from "axios";

export class PhpHubApi extends HttpClient {
    public getListPhpInstances() {
        return this.get('/api/v1/php-instances')
    }

    protected beforeRequest(config: AxiosRequestConfig): AxiosRequestConfig {
        config.baseURL = process.env.VUE_APP_MAIN_HOST_URL;

        return config;
    }
}