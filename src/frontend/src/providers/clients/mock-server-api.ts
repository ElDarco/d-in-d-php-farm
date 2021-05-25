import HttpClient from "@/providers/clients/http-client";
import {AxiosRequestConfig} from "axios";

export class MockServerApi extends HttpClient {
  public createNSpace(
    name: string,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return new Promise((resolve, reject) => {
      this.post('/api/v1/nspace', {
        "name": name
      })
        .then((response) => {
          if (successCallback !== undefined) {
            successCallback(response)
          }
          resolve(response)
        })
        .catch((error) => {
          if (failureCallback !== undefined) {
            failureCallback(error)
          }
          reject(error)
        })
        .finally(() => {
          if (doneCallback !== undefined) {
            doneCallback()
          }
        });
    })
  }

  public async getNSpaceInfo(
    nspace: NSpace | NSpaceInCache,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return new Promise((resolve, reject) => {
      this.get('/api/v1/nspace/' + nspace.id)
        .then((response) => {
          if (successCallback !== undefined) {
            successCallback(response)
          }
          resolve(response)
        })
        .catch((error) => {
          if (failureCallback !== undefined) {
            failureCallback(error)
          }
          reject(error)
        })
        .finally(() => {
          if (doneCallback !== undefined) {
            doneCallback()
          }
        });
    });
  }

  protected beforeRequest(config: AxiosRequestConfig): AxiosRequestConfig {
    config.baseURL = process.env.VUE_APP_MOCK_SERVER_HOST_URL;

    return config;
  }
}