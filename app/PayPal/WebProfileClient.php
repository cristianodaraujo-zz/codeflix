<?php

namespace App\PayPal;

use App\Models\WebProfile as WebProfileLocal;
use PayPal\Api\FlowConfig;
use PayPal\Api\Presentation;
use PayPal\Api\InputFields;
use PayPal\Api\WebProfile as ApiWebProfile;
use PayPal\Rest\ApiContext;

class WebProfileClient
{
    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * WebProfileClient constructor.
     * @param ApiContext $apiContext
     */
    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
    }
    
    public function create(WebProfileLocal $webProfileLocal)
    {
        $flowConfig = new FlowConfig();
        $flowConfig->setLandingPageType('Billing');

        $presentation = new Presentation();
        $presentation
            ->setLogoImage($webProfileLocal->logo_url)
            ->setBrandName($webProfileLocal->name)
            ->setLocaleCode('BR')
            ->setReturnUrlLabel('Retornar')
            ->setNoteToSellerLabel('Obrigado!');

        $inputFields = new InputFields();
        $inputFields
            ->setAllowNote(false)
            ->setNoShipping(1)
            ->setAddressOverride(0);

        $apiWebProfile = new ApiWebProfile();
        $apiWebProfile
            ->setName("$webProfileLocal->name-". uniqid())
            ->setFlowConfig($flowConfig)
            ->setPresentation($presentation)
            ->setInputFields($inputFields)
            ->setTemporary(false);

        return $apiWebProfile->create($this->apiContext);
    }

    public function update(WebProfileLocal $webProfileLocal)
    {
        $apiWebProfile = ApiWebProfile::get($webProfileLocal->code, $this->apiContext);
        $apiWebProfile
            ->setName("$webProfileLocal->name-". uniqid())
            ->getPresentation()
            ->setBrandName($webProfileLocal->name)
            ->setLogoImage($webProfileLocal->logo_url);

        return $apiWebProfile->update($this->apiContext);
    }

    public function delete($webProfileLocalCode)
    {
        $apiWebProfile = ApiWebProfile::get($webProfileLocalCode, $this->apiContext);

        return $apiWebProfile->delete($this->apiContext);
    }
}