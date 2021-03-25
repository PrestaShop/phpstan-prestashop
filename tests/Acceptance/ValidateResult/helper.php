<?php

/**
 * @param array $reportedJSON
 * @param int $numberExpectedErrors
 *
 * @throws RuntimeException if assertion is false
 */
function assertNumberTotalErrors(array $reportedJSON, int $numberExpectedErrors)
{
    $totalReportedErrors = $reportedJSON['totals']['file_errors'];

    if ($totalReportedErrors !== $numberExpectedErrors) {
        throw new RuntimeException(sprintf('Expected %d reported errors, got %d', $numberExpectedErrors, $totalReportedErrors));
    }
}

/**
 * @param array $reportedJSON
 * @param string $givenFileName
 * @param string $errorMessage
 * @param int $lineNumber
 *
 * @throws RuntimeException if assertion is false
 */
function assertFileHasErrorMessage(array $reportedJSON, string $givenFileName, string $errorMessage, int $lineNumber)
{
    foreach ($reportedJSON['files'] as $fileName => $fileData) {
        if (basename($fileName) === $givenFileName) {
            foreach ($fileData['messages'] as $error) {
                if ($error['message'] === $errorMessage) {
                    if ($error['line'] === $lineNumber) {
                        return;
                    }

                    throw new RuntimeException(sprintf('Found error message %s at line %d instead of line %d', $errorMessage, $error['line'], $lineNumber));
                }
            }

            throw new RuntimeException(sprintf('Could not find error message %s in given PHPStan report', $errorMessage));
        }
    }

    throw new RuntimeException(sprintf('Could not find file %s in given PHPStan report', $fileName));
}
