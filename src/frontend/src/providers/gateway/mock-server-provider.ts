import {MockServerApi} from "@/providers/clients/mock-server-api";

export class MockServerProvider {
  protected mockServerApi = new MockServerApi();

  public createNewNSpace(
    name: string,
    proxyToUrl: string,
    useProxy: boolean,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return this.mockServerApi.createNSpace(name, proxyToUrl, useProxy, successCallback, failureCallback, doneCallback)
  }

  public async syncNSpace(
    nSpace: NSpace | NSpaceInCache,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return await this.mockServerApi.getNSpaceInfo(nSpace, successCallback, failureCallback, doneCallback);
  }

  public async createNSettings(
    nSpace: NSpace|NSpaceInCache,
    body: string,
    uri: string,
    method: string,
    code: number,
    queryString: string,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return await this.mockServerApi.createNSettings(nSpace, body, uri, method, code, queryString, successCallback, failureCallback, doneCallback);
  }

  public async clearNSettings(
    nSpace: NSpace | NSpaceInCache,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return await this.mockServerApi.clearNSettings(nSpace, successCallback, failureCallback, doneCallback);
  }

  public async deleteNSpace(
    nSpace: NSpace | NSpaceInCache,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return await this.mockServerApi.deleteNSpace(nSpace, successCallback, failureCallback, doneCallback);
  }
}