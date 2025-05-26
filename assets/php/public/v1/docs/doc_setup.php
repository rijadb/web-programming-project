<?php

/**
 * @OA\Info(
 *   title="API",
 *   description="Web Programming API",
 *   version="1.0",
 *   @OA\Contact(
 *     email="rijad.basic@stu.ibu.edu.ba",
 *     name="Rijad Basic"
 *   )
 * ),
 * @OA\OpenApi(
 *   @OA\Server(
 *       url=BASE_URL
 *   )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */